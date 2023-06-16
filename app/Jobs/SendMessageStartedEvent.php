<?php

namespace App\Jobs;

use App\Mail\SendEventStartedEmail;
use App\Models\Event;
use App\Notifications\SendEventStartedMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use NotificationChannels\Telegram\TelegramMessage;

class SendMessageStartedEvent implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        private Event $event
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
        // Mail::to($this->event->user->email)
        //     ->send(new SendEventStartedEmail($this->event));

        if($this->event->user->tg_token){
            Notification::send($this->event, new SendEventStartedMessage());
        }
    }
}
