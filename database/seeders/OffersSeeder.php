<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Offer;

class OffersSeeder extends Seeder
{
    public function run()
    {
        $offers = [
            [
                'title' => 'Hrana uscata pentru pisici Canagan Dental Curcan 4kg',
                'description' => 'Actioneaza prin fluxul sanguin, eliberand un compus natural in saliva, care descompune filmul bacterian de pe dintii de care se lipeste placa. Boala gingiilor este experimentata de peste doua treimi din pisici si poate fi foarte dureroasa si poate duce la pierderea dintilor.',
                'image_url' => 'https://animax.ro/cdn/shop/products/hrana-uscata-pisici-canagan-dental-curcan-4kg_604x.progressive.png.jpg?v=1666328624',
                'link' => 'https://animax.ro/collections/promotii-pisici/products/hrana-uscata-pentru-pisici-canagan-dental-curcan-4kg?_pos=3&_fid=52f8650f1&_ss=c',
                'category' => 'pisici',
                'price' => 213,
            ],
            [
                'title' => 'Hrana umeda pentru pisici Royal Canin Hair&Skin 85g',
                'description' => 'Hrana umeda, echilibrata si completa special adaptata nevoilor nutritionale ale pisicilor adulte, ajuta la mentinerea sanatatii pielii si blanii (carne maruntita in sos).',
                'image_url' => 'https://animax.ro/cdn/shop/files/rc_fcn_hairskinpouchgravy_5_ro_ro_0_605x.progressive.jpg?v=1693909554',
                'link' => 'https://animax.ro/collections/promotii-pisici/products/hrana-umeda-pentru-pisici-royal-canin-intense-beauty-85g',
                'category' => 'pisici',
                'price' => 7,
            ],
            [
                'title' => 'Jucarie pentru pisici Flamingo Motanul Rizzo',
                'description' => 'Aceasta jucarie este perfecta pentru pisica ta aventuroasa!

Caracteristici:

Fabricat din tesatura moale si umplut cu sunete sifonate, catnip si panglici. 
21 cm
diferite modele (culoarea este aleatorie)',
                'image_url' => 'https://animax.ro/cdn/shop/files/rizzo_604x.progressive.png.jpg?v=1699360009',
                'link' => 'https://animax.ro/collections/promotii-pisici/products/jucarie-pentru-pisici-flamingo-motanul-rizzo',
                'category' => 'pisici',
                'price' => 14,
            ],
            [
                'title' => 'Nisip pentru litiera Sanicat Clumping Vanilie&Mandarina 8L',
                'description' => 'Asternut igienic pentru pisici ce contine bentonita alba.',
                'image_url' => 'https://animax.ro/cdn/shop/files/140183_605x.progressive.png.jpg?v=1722927349',
                'link' => 'https://animax.ro/collections/promotii-pisici/products/nisip-pentru-litiera-sanicat-clumping-vanilie-mandarina-8l',
                'category' => 'pisici',
                'price' => 41,
            ],
        ];

        foreach ($offers as $offer) {
            Offer::create($offer);
        }
    }
}
