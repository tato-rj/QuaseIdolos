<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{User, Admin};

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'user_id' => User::first()->id,
            'instruments' => ['guitarra'],
            'manage_events' => true,
            'manage_setlist' => true
        ]);

        Admin::create([
            'user_id' => User::find(2)->id,
            'instruments' => ['voz'],
        ]);

        Admin::create([
            'user_id' => User::find(3)->id,
            'instruments' => ['voz'],
        ]);

        Admin::create([
            'user_id' => User::find(4)->id,
        ]);
    }
}


