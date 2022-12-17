<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Artist;

class ArtistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $artists = [
            'Adele',
            'Caetano Veloso',
            'Babado Novo',
            'Zeca Pagodinho',
            'The Beatles',
            'Metallica',
            'Beyoncé',
            'É o Tchan',
            'Djavan',
            'Legião Urbana',
            'Gaby Amarantos',
            'Kelly Key',
            'Kelly Clarkson',
            'Eagles',
            'Elis Regina',
            'Goo Goo Dolls',
            'Ivete Sangalo',
            'Grupo 100%',
            'Iza',
            'Spice Girls',
            'Sandy e Júnior',
            'Seu Jorge',
            'Morrissey',
            'Natalie Imbruglia',
            '3 Doors Down',
            '4 Non Blondes',
            '\'NSYNC',
            'Alcione',
            'Avril Lavigne',
            'Armandinho',
            'Araketu',
            'Beto Barbosa',
            'Britney Spears',
            'Anitta',
            'Elvis Presley',
            'Colbie Caillat',
            'Cidade Negra',
            'Bee Gees'
        ];

        foreach ($artists as $artist) {
            Artist::create([
                'name' => $artist,
                'slug' => str_slug($artist),
                'image_path' => 'artists/'.str_slug($artist).'.jpeg'
            ]);
        }
    }
}
