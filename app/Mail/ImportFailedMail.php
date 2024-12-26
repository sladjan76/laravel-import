<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Import;

class ImportFailedMail extends Mailable
{
    use Queueable, SerializesModels;

    public Import $import;
    public string $error;

    public function __construct(Import $import, string $error)
    {
        $this->import = $import;
        $this->error = $error;
    }

    public function build()
    {
        return $this->markdown('emails.imports.failed')
            ->subject('Import Failed: ' . $this->import->import_type);
    }
}
