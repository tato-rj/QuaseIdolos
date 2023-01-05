<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            ArtistSeeder::class,
            GenreSeeder::class,
            SongSeeder::class,
            FavoriteSeeder::class,
            VenueSeeder::class,
            GigSeeder::class,
            ParticipantSeeder::class,
            SongRequestSeeder::class,
            RatingSeeder::class,
            SuggestionSeeder::class,
        ]);

        \Artisan::call('cache:clear');
        \Artisan::call('redis:flush quaseidolos --confirm');
    }
}
