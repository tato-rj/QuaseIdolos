<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{User, Admin};

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
            'password' => \Hash::make('maiden'),
        ]);

        Admin::create([
            'user_id' => User::first()->id,
            'super_admin' => true
        ]);

        User::create([
            'name' => 'Mario Silva',
            'email' => 'mario@email.com',
            'password' => \Hash::make('maiden'),
        ]);

        User::create([
            'name' => 'Carolina Vieira',
            'email' => 'carolina@email.com',
            'password' => \Hash::make('maiden'),
            'avatar_url' => 'https://xsgames.co/randomusers/assets/avatars/female/71.jpg',
        ]);

        User::create([
            'name' => 'João Carvalho',
            'email' => 'joao@email.com',
            'password' => \Hash::make('maiden'),
            'avatar_url' => 'https://xsgames.co/randomusers/assets/avatars/male/6.jpg',
        ]);

        User::create([
            'name' => 'Aline Castro',
            'email' => 'aline@email.com',
            'password' => \Hash::make('maiden'),
            'avatar_url' => 'https://xsgames.co/randomusers/assets/avatars/female/45.jpg',
        ]);

        User::create([
            'name' => 'Bernardo de Carvalho',
            'email' => 'bernardo@email.com',
            'password' => \Hash::make('maiden'),
        ]);   
    }
}


