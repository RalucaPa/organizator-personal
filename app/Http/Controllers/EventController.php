<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Inertia\Inertia;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::orderBy('start_time')->get();

        return Inertia::render('Events/Index', [
            'events' => $events,
        ]);
    }
}
