<?php

use Illuminate\Support\Facades\Route;

Route::get('', function () {
    return view('pages.home.index');
})->name('home');

Route::get('reservas', function () {
    return view('pages.reservas.index');
})->name('reservas');

Route::prefix('auth/{driver}')->group(function() {
    Route::get('redirect', 'Auth\SocialiteController@redirect')->name('socialite');

    Route::get('callback', 'Auth\SocialiteController@callback');
});

Route::middleware('auth')->prefix('meu-perfil')->name('profile.')->group(function() {
    Route::get('', 'UsersController@show')->name('show');

    Route::patch('{user?}', 'UsersController@update')->name('update');

    Route::post('password/{user?}', 'UsersController@password')->name('password');

    Route::delete('{user?}', 'UsersController@destroy')->name('destroy');
});

Route::middleware('admin')->prefix('cantores')->name('users.')->group(function() {
    Route::get('', 'UsersController@index')->name('index');

    Route::get('{user}/editar', 'UsersController@edit')->name('edit');
});

Route::get('cardapio', 'CardapioController@index')->name('cardapio');

Route::prefix('cardapio')->name('cardapio.')->group(function() {
    Route::get('artista/{artist}', 'CardapioController@artist')->name('artist');
    
    Route::get('search', 'CardapioController@search')->name('search');
});

Route::middleware('admin')->prefix('artistas')->name('artists.')->group(function() {
    Route::get('', 'ArtistsController@index')->name('index');

    Route::get('buscar', 'ArtistsController@search')->name('search');

    Route::get('{artist}/editar', 'ArtistsController@edit')->name('edit');

    Route::patch('{artist}', 'ArtistsController@update')->name('update');

    Route::post('store', 'ArtistsController@store')->name('store');

    Route::delete('{artist}', 'ArtistsController@destroy')->name('destroy');
});

Route::middleware('admin')->prefix('musicas')->name('songs.')->group(function() {
    Route::get('', 'SongsController@index')->name('index');

    Route::get('buscar', 'SongsController@search')->name('search');

    Route::get('{song}/editar', 'SongsController@edit')->name('edit');

    Route::patch('{song}', 'SongsController@update')->name('update');

    Route::post('store', 'SongsController@store')->name('store');

    Route::delete('{song}', 'SongsController@destroy')->name('destroy');
});

Route::middleware('admin')->prefix('setlist')->name('setlist.')->group(function() {
    Route::get('', 'SetlistController@live')->name('live');

    Route::post('{setlist}/finish', 'SetlistController@finish')->name('finish');
});

Route::middleware('auth')->prefix('setlist')->name('setlist.')->group(function() {
    Route::get('minha', 'SetlistController@user')->name('user');

    Route::get('alert/user', 'SetlistController@alert')->name('alert');

    Route::get('alert/admin', 'SetlistController@alertAdmin')->name('alert.admin');

    Route::get('table', 'SetlistController@table')->name('table');

    Route::post('{song}', 'SetlistController@store')->name('store');
    
    Route::delete('{setlist}/cancel', 'SetlistController@cancel')->name('cancel');
});

Route::middleware('auth')->prefix('favoritos')->name('favorites.')->group(function() {
    Route::get('', 'FavoritesController@index')->name('index');

    Route::post('{song}', 'FavoritesController@store')->name('store');

    Route::delete('{song}', 'FavoritesController@destroy')->name('destroy');
});

Route::middleware('super-admin')->prefix('team')->name('team.')->group(function() {
    Route::get('', 'TeamController@index')->name('index');

    Route::get('search', 'TeamController@search')->name('search');

    Route::patch('{user}', 'TeamController@update')->name('update');
});
