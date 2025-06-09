<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Models\Event;
use App\Notifications\UpcomingEventNotification;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(function () {
    $tomorrow = now()->addDay()->toDateString();
    $events = Event::with('users')->whereDate('start_time', $tomorrow)->get();

    foreach ($events as $event) {
        foreach ($event->users as $user) {
            Log::info("Notificare pentru utilizator: {$user->email} pentru eveniment: {$event->title} la data: {$event->start_time}");
            // Send notification to the user
            // Ensure the user has an email before sending notification
            if ($user->email) {
                $user->notify(new UpcomingEventNotification($event));
            }
        }
    }
})->everyMinute(); // change to daily after testing
// })->dailyAt('08:00');
