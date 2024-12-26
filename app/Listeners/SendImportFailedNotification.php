<?php

namespace App\Listeners;

use App\Events\ImportFailed;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\ImportFailedMail;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendImportFailedNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(ImportFailed $event)
    {
        Mail::to($event->import->user->email)
            ->send(new ImportFailedMail($event->import, $event->error));
    }
}

