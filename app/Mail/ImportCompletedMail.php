<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Import;

class ImportCompletedMail extends Mailable
{
    use Queueable, SerializesModels;

    public Import $import;
    public array $result;

    public function __construct(Import $import, array $result)
    {
        $this->import = $import;
        $this->result = $result;
    }

    public function build()
    {
        return $this->markdown('emails.imports.completed')
            ->subject('Import Completed: ' . $this->import->import_type);
    }
}
