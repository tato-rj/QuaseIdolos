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
        foreach(User::guests()->inRandomOrder()->take(2)->get() as $user) {
            Suggestion::factory()->create(['user_id' => $user->id]);
        }
    }
}
