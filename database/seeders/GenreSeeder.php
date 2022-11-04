<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Genre;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Genre::insert([
            [
                'name' => 'Axé',
                'slug' => str_slug('Axé'),
                'image_path' => 'genres/axe.jpg'
            ],[
                'name' => 'Pop/Rock',
                'slug' => str_slug('Pop/Rock'),
                'image_path' => 'genres/rock.jpg'
            ],[
                'name' => 'Pagode',
                'slug' => str_slug('Pagode'),
                'image_path' => 'genres/pagode.jpg'
            ],[
                'name' => 'Bossa Nova',
                'slug' => str_slug('Bossa Nova'),
                'image_path' => 'genres/bossa-nova.jpg'
            ],[
                'name' => 'Sertanejo',
                'slug' => str_slug('Sertanejo'),
                'image_path' => 'genres/sertanejo.jpg'
            ],[
                'name' => 'MPB',
                'slug' => str_slug('MPB'),
                'image_path' => 'genres/mpb.jpg'
            ],[
                'name' => 'Soul',
                'slug' => str_slug('Soul'),
                'image_path' => 'genres/soul.jpg'
            ],[
                'name' => 'Reggae',
                'slug' => str_slug('Reggae'),
                'image_path' => 'genres/reggae.jpg'
            ]]);
    }
}
