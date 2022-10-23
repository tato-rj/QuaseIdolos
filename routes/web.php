<?php

use Illuminate\Support\Facades\Route;

Route::get('', function () {
    return view('pages.home.index');
})->name('home');

Route::get('cardapio', function () {
    $artists = [
        ['name' => '4 Non Blonds'],
        ['name' => 'Adele'],
        ['name' => 'Zezé di Camargo e Luciano'],
        ['name' => 'Titãs'],
        ['name' => 'Anitta'],
        ['name' => 'Tribalistas'],
        ['name' => 'Falamansa'],
        ['name' => 'Justin Bieber'],
        ['name' => 'Aerosmith'],
        ['name' => 'Bruno Mars'],
        ['name' => 'Charlie Brown Jr.'],
        ['name' => 'Frank Sinatra'],
        ['name' => 'Naldo Benny'],
        ['name' => 'Onze e Vinte'],
        ['name' => 'Ivete Sangalo'],
        ['name' => 'Iron Maiden'],
        ['name' => 'Rosannah'],
        ['name' => 'Herva Doce'],
        ['name' => 'Skank'],
        ['name' => 'Shakira'],
        ['name' => 'O Rappa'],
        ['name' => 'Fundo de Quintal'],
    ];

    return view('pages.cardapio.index', compact('artists'));
})->name('cardapio');
