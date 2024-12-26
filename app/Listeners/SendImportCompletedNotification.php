<?php

namespace App\Listeners;

use App\Events\ImportCompleted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\ImportCompletedMail;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendImportCompletedNotification implements  ShouldQueue
{
    use InteractsWithQueue;

    public function handle(ImportCompleted $event)
    {
        Mail::to($event->import->user->email)
            ->send(new ImportCompletedMail($event->import, $event->result));
    }
}
