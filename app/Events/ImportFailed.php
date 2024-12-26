<?php

namespace App\Events;

use App\Models\Import;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ImportFailed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Import $import;
    public string $error;

    public function __construct(Import $import, string $error)
    {
        $this->import = $import;
        $this->error = $error;
    }
}
