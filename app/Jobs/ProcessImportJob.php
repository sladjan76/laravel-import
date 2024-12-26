<?php

namespace App\Jobs;

use App\Models\Import;
use App\Services\ImportService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Events\ImportCompleted;
use App\Events\ImportFailed;
use Exception;

class ProcessImportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $import;
    public $tries = 3;
    public $timeout = 3600;


    public function __construct(Import $import)
    {
        $this->import = $import;
    }

    public function handle(ImportService $importService)
    {
        try {
            $this->import->update(['status' => 'processing']);

            $result = $importService->processImport($this->import);

            $this->import->update([
                'status' => ($result['error_rows'] > 0) ? 'completed_with_errors' : 'completed'
            ]);

            \Log::info('Import completed', [
                'import_id' => $this->import->id,
                'result' => $result
            ]);

            event(new ImportCompleted($this->import, $result));

        } catch (Exception $e) {
            \Log::error('Import job failed', [
                'import_id' => $this->import->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            $this->import->update(['status' => 'failed']);

            event(new ImportFailed($this->import, $e->getMessage()));

            throw $e;
        }
    }

}
