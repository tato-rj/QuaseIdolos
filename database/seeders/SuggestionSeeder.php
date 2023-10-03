<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Suggestion, User};

class SuggestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Suggestion::factory()->create([
            'user_id' => User::guests()->inRandomOrder()->first(),
            'artist_name' => 'Eric Clapton',
            'song_name' => 'Tears In Haven'
        ]);

        Suggestion::factory()->create([
            'user_id' => User::guests()->inRandomOrder()->first(),
            'artist_name' => 'Kid Abelha',
            'song_name' => 'Fixacao'
        ]);
    }
}
