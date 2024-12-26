<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Import;
use App\Jobs\ProcessImportJob;
use Illuminate\Support\Facades\Config;
use App\Http\Requests\Admin\StoreImportRequest;

class ImportController extends Controller
{
    /**
     * Display Imports form.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        // Get import types from config that user has permission for
        $importTypes = collect(Config::get('imports'))->filter(function ($config, $type) {
            return auth()->user()->hasPermissionTo($config['permission_required']);
        });

        return view('admin.imports.index', compact('importTypes'));
    }

    /**
     * Stores Imports.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreImportRequest $request)
    {

        $importType = Config::get("imports.{$request->import_type}");

        if (!$importType) {
            return redirect()->back()->with('import_error', 'Invalid import type');
        }

        if (!auth()->user()->hasPermissionTo($importType['permission_required'])) {
            return redirect()->back()->with('import_error', 'Unauthorized');
        }

        $files = [];
        foreach ($request->file('files') as $key => $file) {
            if (!isset($importType['files'][$key])) {
                return back()->with('import_error', 'Invalid file configuration');
            }

            $path = $file->store('imports');
            $files[$key] = [
                'path' => $path,
                'original_name' => $file->getClientOriginalName()
            ];
        }

       try {
           $import = Import::create([
               'user_id' => auth()->id(),
               'import_type' => $request->import_type,
               'file_name' => json_encode($files),
               'original_file_name' => $files[array_key_first($files)]['original_name'],
               'status' => 'pending'
           ]);

            ProcessImportJob::dispatch($import);

           return redirect()->back()
               ->with('success', 'Import has been queued for processing. You will be notified when it completes.');

       } catch (\Exception $e) {
            return redirect()->back()
                ->with('import_error', 'Failed to initiate import.')
                ->with('error_details', [$e->getMessage()])
                ->withInput();
        }
    }

}
