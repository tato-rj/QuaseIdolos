<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Arthur Villar',
            'email' => 'arthurvillar@gmail.com',
            'is_admin' => true,
            'password' => \Hash::make('maiden'),
        ]);

        User::create([
            'name' => 'John Doe',
            'email' => 'doe@email.com',
            'password' => \Hash::make('maiden'),
        ]);
    }
}
