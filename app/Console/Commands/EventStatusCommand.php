<?php

namespace App\Console\Commands;

use App\Jobs\SendMessageExpiredEvent;
use App\Jobs\SendMessageStartedEvent;
use App\Models\Event;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class EventStatusCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'event:status
        {--started : Початок події}
        {--expired : Завершення події}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Зміна статусу подій';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if($this->option('started')){
            Event::withStatus(Event::NEW)
                ->withStarted()
                ->chunk(100, function(Collection $events) {
                    $events->each(function(Event $event) {
                        dispatch(new SendMessageStartedEvent($event))->onQueue('event');
                        $event->update(['status' => Event::IN_PROGRES]);
                    });
                });
        }

        if($this->option('expired')){
            Event::withStatus(Event::IN_PROGRES)
                ->withExpired()
                ->chunk(100, function(Collection $events) {
                    $events->each(function(Event $event) {
                        dispatch(new SendMessageExpiredEvent($event))->onQueue('event');
                        $event->update(['status' => Event::COMPLETED]);
                    });
                });
        }
    }
}
