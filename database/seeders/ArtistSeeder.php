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
        Artist::insert([
            [
                'name' => 'Adele',
                'slug' => str_slug('Adele'),
                'image_path' => 'artists/adele.jpeg'
            ],[
                'name' => 'Caetano Veloso',
                'slug' => str_slug('Caetano Veloso'),
                'image_path' => 'artists/caetano.jpeg'
            ],[
                'name' => 'Babado Novo',
                'slug' => str_slug('Babado Novo'),
                'image_path' => 'artists/babado.jpeg'
            ],[
                'name' => 'Zeca Pagodinho',
                'slug' => str_slug('Zeca Pagodinho'),
                'image_path' => 'artists/zeca.jpeg'
            ],[
                'name' => 'The Beatles',
                'slug' => str_slug('The Beatles'),
                'image_path' => 'artists/beatles.jpeg'
            ],[
                'name' => 'Metallica',
                'slug' => str_slug('Metallica'),
                'image_path' => 'artists/mettalica.jpeg'
            ],[
                'name' => 'Beyoncé',
                'slug' => str_slug('Beyoncé'),
                'image_path' => 'artists/beyonce.jpeg'
            ],[
                'name' => 'É o Tchan',
                'slug' => str_slug('É o Tchan'),
                'image_path' => 'artists/tchan.jpeg'
            ],[
                'name' => 'Djavan',
                'slug' => str_slug('Djavan'),
                'image_path' => 'artists/djavan.jpeg'
            ],[
                'name' => 'Legião Urbana',
                'slug' => str_slug('Legião Urbana'),
                'image_path' => 'artists/legiao.jpeg'
            ],[
                'name' => 'Gaby Amarantos',
                'slug' => str_slug('Gaby Amarantos'),
                'image_path' => 'artists/gaby.jpeg'
            ],[
                'name' => 'Kelly Key',
                'slug' => str_slug('Kelly Key'),
                'image_path' => 'artists/kelly.jpeg'
            ]
        ]);
    }
}
