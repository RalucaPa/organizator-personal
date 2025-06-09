<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Event;
use Carbon\Carbon;

class AiEventController extends Controller
{
    public function addEvent(Request $request)
    {
        $command = $request->input('command');

        $response = Http::withToken(env('OPENAI_API_KEY'))->post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                [
                    'role' => 'system', 'content' => 'Primesti un text de la utilizator care descrie un eveniment cultural. Returneaza un obiect JSON cu urmatoarele chei:
                    - "title": doar titlul principal al evenimentului (ex: titlul piesei sau filmului),
                    - "start_time": data si ora in format ISO 8601 (ex: 2025-05-15T19:00:00),
                    - "location": locatia fara prescurtari sau paranteze,
                    - "description": restul informatiilor utile din propozitie, de exemplu ce tip de piesa/cu cine merg/unde ne intalnim.
                    Astazi este ' . now()->format('Y-m-d') . '.'
                ],
                [
                    'role' => 'user', 
                    'content' => $command
                ],
            ],
            'temperature' => 0.3,
        ]);

        Log::info('Răspuns OpenAI:', ['body' => $response->body()]);

        $content = $response->json();
        $raw = $content['choices'][0]['message']['content'] ?? null;

        if (!$raw) {
            return response()->json(['error' => 'Raspuns invalid de la AI.'], 500);
        }

        // extract JSON from the response
        $raw = trim($raw);
        if (preg_match('/\{.*\}/s', $raw, $matches)) {
            $raw = $matches[0];
        }

        $data = json_decode($raw, true);

        $startTime = Carbon::parse($data['start_time'])->toDateTimeString();

        if (!$data || !isset($data['title'], $startTime, $data['location'])) {
            return response()->json(['error' => 'Date lipsa in raspunsul AI.'], 422);
        }

        // Create event
        $event = Event::create([
            'title' => $data['title'],
            'start_time' => $data['start_time'],
            'location' => $data['location'],
            'description' => $data['description'] ?? null,
        ]);


        // Save event in calendar
        $request->user()->savedEvents()->attach($event->id);

        return response()->json(['success' => true, 'event' => $event]);
    }
}
