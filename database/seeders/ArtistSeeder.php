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
            'Adele' => '4dpARuHxo51G3z768sgnrY',
            'Caetano Veloso' => '7HGNYPmbDrMkylWqeFCOIQ',
            'The Beatles' => '3WrFJ7ztbogyGnTHbHJFl2',
            'Babado Novo',
            'Zeca Pagodinho',
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

        foreach ($artists as $artist => $spotifyId) {
            Artist::create([
                'name' => $artist,
                'spotify_id' => $spotifyId ?? null,
                'slug' => str_slug($artist),
                'image_path' => 'artists/'.str_slug($artist).'.jpeg'
            ]);
        }
    }
}
