<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Note;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::orderBy('start_time')->get();
        $notite = Note::where('user_id', auth()->id())->latest()->take(5)->get();

        return Inertia::render('Events/Index', [
            'events' => $events,
            'notite' => $notite
        ]);
    }
}
