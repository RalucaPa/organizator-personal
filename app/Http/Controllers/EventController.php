<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Note;
use App\Models\Offer; 
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::orderBy('start_time')->get();
        $notite = Note::where('user_id', auth()->id())->latest()->take(5)->get();

        $addedEventIds = DB::table('user_events')
            ->where('user_id', auth()->id())
            ->pluck('event_id');

        $preferinteLocatii = Event::whereIn('id', $addedEventIds)
            ->pluck('location')
            ->countBy()
            ->sortDesc()
            ->keys()
            ->take(1);
            
        $recommendedEvents = Event::whereNotIn('id', $addedEventIds)
            ->when($preferinteLocatii->isNotEmpty(), fn($q) => $q->where('location', $preferinteLocatii->first()))
            // ->whereDate('start_time', '>=', now())
            ->inRandomOrder()
            ->take(3)
            ->get();


        return Inertia::render('Events/Index', [
            'events' => $events,
            'offers' => $recommendedEvents,
            'notite' => $notite
        ]);
    }
}
