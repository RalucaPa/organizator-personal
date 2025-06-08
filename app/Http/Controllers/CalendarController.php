<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Inertia\Inertia;
use Carbon\Carbon;

class CalendarController extends Controller
{
    public function index()
    {
        return Inertia::render('Calendar/Index');
    }

    public function getEvents()
    {
        return auth()->user()->savedEvents->map(function ($event) {
            return [
                'title' => $event->title,
                'start' => \Carbon\Carbon::parse($event->start_time)->toAtomString(),
                'location' => $event->location,
                'description' => $event->description,
            ];
        });
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['start_time'] = $data['start'] ?? null;
        unset($data['start']);

        $validated = validator($data, [
            'title' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'start_time' => 'required|date',
        ])->validate();

        $event = Event::create($validated);

        return response()->json($event);
    }
}