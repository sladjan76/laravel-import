<?php

namespace App\Events;

use App\Models\Import;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ImportCompleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Import $import;
    public array $result;

    public function __construct(Import $import, array $result)
    {
        $this->import = $import;
        $this->result = $result;
    }

}
