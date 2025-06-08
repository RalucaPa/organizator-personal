<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;

class EvenimentTest extends TestCase
{
    use RefreshDatabase;

    // This test simulates the AI event creation process by mocking the OpenAI API response,
    // creating a user, and sending a command to the AI endpoint. It checks if the event is created successfully
    // and stored in the database. The test uses Laravel's HTTP fake feature to simulate the API response
    // without making actual network requests, ensuring that the test is fast and reliable.
    public function testCreateEventFromCommand(): void
    {
        Http::fake([
            'https://api.openai.com/*' => Http::response([
                'choices' => [[
                    'message' => [
                        'content' => json_encode([
                            'title' => 'Concert Jazz',
                            'start_time' => '2025-06-20T18:00:00',
                            'location' => 'Sala Palatului',
                            'description' => 'Seară de jazz cu prietenii.',
                        ])
                    ]
                ]]
            ], 200),
        ]);


        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post('/ai/add-event', [
            'command' => 'Mergem la un concert de jazz vineri seara la Sala Palatului.',
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'title' => 'Concert Jazz',
            'location' => 'Sala Palatului',
        ]);

        $this->assertDatabaseHas('events', [
            'title' => 'Concert Jazz',
            'location' => 'Sala Palatului',
        ]);
    }
}
