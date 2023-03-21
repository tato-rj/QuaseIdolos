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
            '4dpARuHxo51G3z768sgnrY' => 'Adele',
            '7HGNYPmbDrMkylWqeFCOIQ' => 'Caetano Veloso',
            '3WrFJ7ztbogyGnTHbHJFl2' => 'The Beatles',
            '2jGuS7w8SfDzRNbxW1Lo2c' => 'Babado Novo',
            '3qZ2n5keOAat1SoF6bHwmb' => 'Zeca Pagodinho',
            '2ye2Wgw4gimLv2eAKyk1NB' => 'Metallica',
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

        foreach ($artists as $spotifyId => $artist) {
            Artist::create([
                'name' => $artist,
                'spotify_id' => is_int($spotifyId) ? null : $spotifyId,
                'slug' => str_slug($artist),
                'image_path' => 'artists/'.str_slug($artist).'.jpeg'
            ]);
        }
    }
}
