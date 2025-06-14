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

        $eventTitles = [
            'Street Food Festival',
            'Noaptea Muzeelor',
            'Târg de carte Gaudeamus',
            'Festivalul Internațional de Teatru',
            'Concert în aer liber – Parcul Izvor',
            'Tur ghidat al Centrului Vechi',
            'Atelier de pictură pentru adulți',
            'Yoga în parc – Herăstrău',
            'Festivalul de film european',
            'Bucharest Tech Meetup',
            'Crosul Color Run',
            'Ziua Copilului în Parcul Carol',
            'Jazz în Grădina Botanică',
            'Piața Vintage – Universitate',
            'Seară de stand-up comedy',

            'Atelier de fotografie în Grădina Botanică',
            'Festivalul de muzică electronică',
            'Târg de produse handmade',
            'Concert simfonic la Ateneu',
            'Festivalul de dans contemporan',
            'Expoziție de artă contemporană',
            'Workshop de gătit tradițional românesc',
            'Festivalul de literatură și poezie',
            'Seară de muzică clasică la Operă',
            'Festivalul de jazz și blues',
            'Târg de produse bio și ecologice',
            'Festivalul de film documentar',
            'Atelier de ceramică pentru începători',
        ];

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
            "Gradina Botanica",
            "Gradina Botanica",
            "Parcul Cismigiu",
            "Gradina Botanica",
            "Parcul Izvor",
            "Parcul Tineretului",
            "Parcul Tineretului",
            "Parcul Izvor",
            "Parcul Carol",
            "Parcul Alexandru Ioan Cuza",
            "Parcul Alexandru Ioan Cuza",
            "Parcul Cismigiu",
        ];

        $descriptions = [
            'Vino să descoperi cele mai bune preparate culinare în aer liber!',
            'Participă la un eveniment cultural inedit cu intrare liberă.',
            'O experiență unică pentru iubitorii de carte și cultură.',
            'Spectacole captivante susținute de trupe internaționale.',
            'Un eveniment relaxant în mijlocul naturii, cu muzică live.',
            'Explorează istoria și arhitectura orașului cu un ghid local.',
            'Activitate creativă ideală pentru o seară liniștită.',
            'Respiră adânc și relaxează-te cu yoga în parc.',
            'Filme europene premiate, proiecții în aer liber și în săli.',
            'Networking și prezentări tech pentru pasionații de IT.',
            'Cros distractiv cu pudră colorată pentru toate vârstele.',
            'Activități pentru copii, jocuri și spectacole interactive.',
            'Seară de jazz live într-un cadru natural relaxant.',
            'Descoperă haine, accesorii și obiecte vintage.',
            'Stand-up comedy cu invitați speciali, garantat râs.',
            'Învață să surprinzi natura prin fotografie alături de un expert.',
            'Muzică electronică și DJ locali într-un cadru vibrant.',
            'Târg cu produse unicat, handmade, de la meșteșugari locali.',
            'Concert simfonic cu lucrări celebre la Ateneu.',
            'Dans contemporan și spectacole inovatoare pe scena locală.',
            'Expoziție cu lucrări de artă contemporană de artiști români.',
            'Învață să gătești preparate tradiționale românești.',
            'Lecturi, discuții și întâlniri cu autori contemporani.',
            'Seară de muzică clasică cu orchestre renumite la Operă.',
            'Festival cu trupe de jazz și blues din România și nu numai.',
            'Târg cu produse bio, ecologice și sustenabile.',
            'Proiecții de filme documentare cu teme sociale și culturale.',
            'Atelier practic pentru cei pasionați de ceramică.',
        ];

        foreach (range(1, 20) as $i) {
        $index = $faker->numberBetween(0, count($eventTitles) - 1);

            Event::create([
                'title' => $eventTitles[$index],
                'description' => $descriptions[$index],
                'location' => $faker->randomElement($locations),
                'image_url' => $faker->imageUrl(640, 480, 'city', true),
                'start_time' => $faker->dateTimeBetween('2025-05-01', '2025-06-30'),
                'end_time' => null,
            ]);
        }
    }
}
