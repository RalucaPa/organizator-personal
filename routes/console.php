<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Models\Event;
use App\Notifications\UpcomingEventNotification;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(function () {
    $tomorrow = now()->addDay()->startOfDay();
    $events = Event::whereDate('start_time', $tomorrow)->get();

    foreach ($events as $event) {
        if ($event->user) {
            $event->user->notify(new UpcomingEventNotification($event));
        }
    }
})->dailyAt('08:00');
