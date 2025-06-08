<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class UserEventController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
        ]);

        $user = Auth::user();

        $user->savedEvents()->syncWithoutDetaching([$request->event_id]);

        return response()->json(['message' => 'Evenimentul a fost adaugat cu succes.']);
    }

    public function index()
    {
        return auth()->user()->savedEvents()->get()->map(function ($event) {
            return [
                'title' => $event->title,
                'start' => \Carbon\Carbon::parse($event->start_time)->toAtomString(),
                'location' => $event->location,
                'description' => $event->description,
            ];
        });
    }
}
