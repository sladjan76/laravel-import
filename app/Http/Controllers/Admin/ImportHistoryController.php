<?php

namespace App\Http\Controllers\Admin;

use App\Models\Import;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ImportHistoryController extends Controller
{

    /**
     * Display a listing of Imports.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {

        $imports = Import::limit(10)->get();
        return view('admin.import_history.index', compact('imports'));
    }

    /**
     * Display a listing of Imports in Json.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function imports(Request $request)
    {

        $columns = array(
            0 => 'id',
            1 => 'id',
            2 => 'import_type',
            3 => 'file',
            4 => 'status',
            5 => 'created_at',
            6 => 'id',
            7 => 'DT_RowId',
        );

        $totalData = Import::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {
            $rows = Import::select('*');
            if($limit > 0) {
                $rows->offset($start);
                $rows->limit($limit);
            }
            $rows->orderBy($order,$dir);
            $imports = $rows->get();

        } else {
            $search = $request->input('search.value');

            $rows = Import::select('*');
            $rows->where('original_file_name','LIKE',"{$search}%");
            if($limit > 0) {
                $rows->offset($start);
                $rows->limit($limit);
            }
            $rows->orderBy($order,$dir);
            $imports = $rows->get();

            $totalFiltered = Import::select('*')
                ->where('original_file_name','LIKE',"{$search}%")
                ->count();
        }

        $data = array();
        if(!empty($imports))
        {
            foreach ($imports as $import)
            {
                $errors = route('admin.import_history.errors',$import->id);
                $delete = route('admin.import_history.destroy',$import->id);

                $nestedData['id'] = $import->id;
                $nestedData['import_type'] = $import->import_type;
                $nestedData['file'] = $import->original_file_name;
                $nestedData['status'] = $import->status;
                $nestedData['created_at'] = $import->created_at->toDateTimeString();

                $nestedData['actions'] = "<a href='{$errors}' class='btn btn-xs btn-info'>View Errors</a>
                <input class='btn btn-xs btn-danger' type='button' onclick='delete_item({$import->id})' value='Delete'>";

                $nestedData['DT_RowId'] = $import->id;
                $data[] = $nestedData;
            }
        }

        return response()->json([
            'data' => $data,
            'draw' => intval($request->input('draw')),
            'recordsTotal' => intval($totalData),
            'recordsFiltered' => intval($totalFiltered),
        ], 201);
    }

    /**
     * Shows Import Errors.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function errors($id)
    {
        $import = Import::where('id', $id)->first();
        $import_errors = $import->errors;

        return view('admin.import_history.errors', compact('import', 'import_errors'));
    }

    /**
     * Remove Import from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        ### Delete import ###
        $import = Import::find($id);
        $import->delete();

        return redirect()->route('admin.import_history.index');
    }

    /**
     * Delete all selected Imports at once.
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function massDestroy(Request $request)
    {
        if ($request->input('ids')) {
            $entries = Import::whereIn('id', $request->input('ids'))->get();
            foreach ($entries as $entry) {
                ### Delete import ###
                $entry->delete();
            }
        }
    }

}
