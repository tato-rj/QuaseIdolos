<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{SongRequest, User};

class RatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(SongRequest::take(20)->get() as $songRequest) {
            User::inRandomOrder()->first()->rate($songRequest, randomFromArray([1,2,3,4,5]));
        }
    }
}
