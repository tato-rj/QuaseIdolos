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
            'instrument' => 'guitar',
            'super_admin' => true
        ]);

        Admin::create([
            'user_id' => User::find(2)->id,
            'instrument' => 'bass',
        ]);

        Admin::create([
            'user_id' => User::find(3)->id,
            'instrument' => 'voice',
        ]);

        Admin::create([
            'user_id' => User::find(4)->id,
        ]);
    }
}


