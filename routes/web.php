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

Route::middleware('admin')->prefix('setlist')->name('setlists.')->group(function() {
    
    Route::get('', 'SetlistsController@show')->name('show');

});

Route::middleware('admin')->prefix('pedido-de-musica')->name('song-requests.')->group(function() {

    Route::post('{songRequest}/finish', 'SongRequestsController@finish')->name('finish');

});

Route::middleware('auth')->prefix('pedido-de-musica')->name('song-requests.')->group(function() {
    Route::get('minha', 'SongRequestsController@user')->name('user');

    Route::get('alert/user', 'SongRequestsController@alert')->name('alert');

    Route::get('alert/admin', 'SongRequestsController@alertAdmin')->name('alert.admin');

    Route::get('table', 'SongRequestsController@table')->name('table');

    Route::post('{song}', 'SongRequestsController@store')->name('store');
    
    Route::delete('{songRequest}/cancel', 'SongRequestsController@cancel')->name('cancel');
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

Route::middleware('super-admin')->prefix('gig')->name('gig.')->group(function() {
    Route::get('', 'GigsController@index')->name('index');

    Route::get('search', 'GigsController@search')->name('search');

    Route::get('{gig}', 'GigsController@edit')->name('edit');

    Route::post('', 'GigsController@store')->name('store');

    Route::patch('{gig}', 'GigsController@update')->name('update');

    Route::post('{gig}/status', 'GigsController@status')->name('status');

    Route::post('{gig}/pause', 'GigsController@pause')->name('pause');

    Route::delete('{gig}', 'GigsController@destroy')->name('destroy');
});
