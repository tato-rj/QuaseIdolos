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
            'password' => \Hash::make('asd'),
        ]);

        User::create([
            'name' => 'Mario Silva',
            'email' => 'mario@email.com',
            'password' => \Hash::make('asd'),
        ]);

        User::create([
            'name' => 'Carolina Vieira',
            'email' => 'carolina@email.com',
            'password' => \Hash::make('asd'),
            'avatar_url' => 'https://scontent-lga3-1.xx.fbcdn.net/v/t1.6435-9/93791894_2896396493814497_6951677037006290944_n.jpg?_nc_cat=100&ccb=1-7&_nc_sid=09cbfe&_nc_ohc=1E0AwmQic5AAX9VIZda&_nc_ht=scontent-lga3-1.xx&oh=00_AT8tUp1AJ7ApyljeCV01zNvcILU606pSd6AxtnOyl1rODw&oe=637C10BB',
        ]);

        User::create([
            'name' => 'João Carvalho',
            'email' => 'joao@email.com',
            'password' => \Hash::make('asd'),
            'avatar_url' => 'https://scontent-lga3-1.xx.fbcdn.net/v/t39.30808-6/292609744_482283967233321_6872630834639363044_n.jpg?_nc_cat=104&ccb=1-7&_nc_sid=09cbfe&_nc_ohc=rdbZhKrUjvkAX9Mxq0K&_nc_ht=scontent-lga3-1.xx&oh=00_AT-jUFoVvk8ZFH28ElEZIXSUfa879n7LJymJOfUB3e3GDw&oe=635D2B00',
        ]);

        User::create([
            'name' => 'Aline Castro',
            'email' => 'aline@email.com',
            'password' => \Hash::make('asd'),
            'avatar_url' => 'https://scontent-lga3-1.xx.fbcdn.net/v/t1.18169-9/1459666_1499058763687842_3138099406797098495_n.jpg?_nc_cat=104&ccb=1-7&_nc_sid=973b4a&_nc_ohc=TNQ5pH_I_dgAX-EoQHn&_nc_ht=scontent-lga3-1.xx&oh=00_AT_-NNCGxoKzK3cIY6i6KHUJ3nJaGCdstk_cLshW7JUSMA&oe=637FF909',
        ]);

        User::create([
            'name' => 'Bernardo de Carvalho',
            'email' => 'bernardo@email.com',
            'password' => \Hash::make('asd'),
        ]);   
    }
}


