<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        $locations = [
            "Teatrul National",
            "Cinema City AFI",
            "Arena Nationala",
            "Romexpo",
            "Parcul Herastrau",
            "Arenele Romane",
            "Teatrul Odeon",
            "Stadionul Steaua",
            "Gradina Botanica",
            "Opera Nationala",
        ];

        foreach (range(1, 20) as $i) {
            Event::create([
                'title' => $faker->sentence(3),
                'description' => $faker->paragraph(),
                'location' => $faker->randomElement($locations),
                'start_time' => $faker->dateTimeBetween('+1 day', '+1 month'),
                'end_time' => null,
            ]);
        }
    }
}
