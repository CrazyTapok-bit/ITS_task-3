<?php

namespace App\Jobs;

use App\Mail\SendReminderEmail;
use App\Models\Reminder;
use App\Notifications\SendReminderMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class SendMessageReminder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        private Reminder $reminder
    )
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->reminder->user->email)
            ->send(new SendReminderEmail($this->reminder));

        if($this->reminder->user->tg_token){
            Notification::send($this->reminder, new SendReminderMessage());
        }
    }
}
