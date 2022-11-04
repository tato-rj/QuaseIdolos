<?php

use Illuminate\Support\Facades\Route;

//////////////////
// GUEST ROUTES //
//////////////////

Route::get('', 'ViewsController@home')->name('home');

Route::get('reservas', 'ViewsController@reservations')->name('reservas');

Route::prefix('auth/{driver}')->group(function() {
    Route::get('redirect', 'Auth\SocialiteController@redirect')->name('socialite');

    Route::get('callback', 'Auth\SocialiteController@callback');
});

Route::prefix('cardapio')->name('cardapio.')->group(function() {
    Route::get('', 'CardapioController@index')->name('index');

    Route::get('artista/{artist}', 'CardapioController@artist')->name('artist');
    
    Route::get('search', 'CardapioController@search')->name('search');
});

/////////////////
// AUTH ROUTES //
/////////////////

Route::middleware('auth')->group(function() {
    Route::prefix('meu-perfil')->name('profile.')->group(function() {
        Route::get('', 'UsersController@show')->name('show');

        Route::patch('{user?}', 'UsersController@update')->name('update');

        Route::post('password/{user?}', 'UsersController@password')->name('password');

        Route::delete('{user?}', 'UsersController@destroy')->name('destroy');
    });

    Route::prefix('setlist')->name('setlists.')->group(function() {
        Route::get('', 'SetlistsController@user')->name('user');

        Route::get('alert/user', 'SongRequestsController@alert')->name('alert.user');

        Route::get('alert/admin', 'SongRequestsController@alertAdmin')->name('alert.admin');
    });

    Route::prefix('pedido-de-musica')->name('song-requests.')->group(function() {
        Route::post('{song}', 'SongRequestsController@store')->name('store');
        
        Route::delete('{id}/cancelar', 'SongRequestsController@cancel')->name('cancel');
    });

    Route::prefix('favoritos')->name('favorites.')->group(function() {
        Route::get('', 'FavoritesController@index')->name('index');

        Route::post('{song}', 'FavoritesController@store')->name('store');

        Route::delete('{song}', 'FavoritesController@destroy')->name('destroy');
    });
});

//////////////////
// ADMIN ROUTES //
//////////////////

Route::middleware('admin')->group(function() {
    Route::prefix('cantores')->name('users.')->group(function() {
        Route::get('', 'UsersController@index')->name('index');

        Route::get('{user}/editar', 'UsersController@edit')->name('edit');
    });

    Route::prefix('artistas')->name('artists.')->group(function() {
        Route::get('', 'ArtistsController@index')->name('index');

        Route::get('buscar', 'ArtistsController@search')->name('search');

        Route::get('{artist}/editar', 'ArtistsController@edit')->name('edit');

        Route::patch('{artist}', 'ArtistsController@update')->name('update');

        Route::post('store', 'ArtistsController@store')->name('store');

        Route::delete('{artist}', 'ArtistsController@destroy')->name('destroy');
    });

    Route::prefix('musicas')->name('songs.')->group(function() {
        Route::get('', 'SongsController@index')->name('index');

        Route::get('buscar', 'SongsController@search')->name('search');

        Route::get('{song}/editar', 'SongsController@edit')->name('edit');

        Route::patch('{song}', 'SongsController@update')->name('update');

        Route::post('store', 'SongsController@store')->name('store');

        Route::delete('{song}', 'SongsController@destroy')->name('destroy');
    });

    Route::prefix('pedido-de-musica')->name('song-requests.')->group(function() {

        Route::post('{songRequest}/finish', 'SongRequestsController@finish')->name('finish');

    });

    Route::prefix('setlist')->name('setlists.')->group(function() {
        Route::get('admin', 'SetlistsController@admin')->name('admin');

        Route::get('table', 'SetlistsController@table')->name('table');
    });

    Route::prefix('estilos')->name('genres.')->group(function() {
        Route::get('', 'GenresController@index')->name('index');

        Route::post('', 'GenresController@store')->name('store');

        Route::patch('{genre}', 'GenresController@update')->name('update');

        Route::delete('{genre}', 'GenresController@destroy')->name('destroy');
    });
});

////////////////////////
// SUPER ADMIN ROUTES //
////////////////////////

Route::middleware('super-admin')->group(function() {
    Route::prefix('team')->name('team.')->group(function() {
        Route::get('', 'TeamController@index')->name('index');

        Route::get('search', 'TeamController@search')->name('search');

        Route::patch('{user}', 'TeamController@update')->name('update');
    });

    Route::prefix('gig')->name('gig.')->group(function() {
        Route::get('', 'GigsController@index')->name('index');

        Route::get('search', 'GigsController@search')->name('search');

        Route::get('{gig}', 'GigsController@edit')->name('edit');

        Route::post('', 'GigsController@store')->name('store');

        Route::patch('{gig}', 'GigsController@update')->name('update');

        Route::post('{gig}/duplicate', 'GigsController@duplicate')->name('duplicate');

        Route::post('{gig}/status', 'GigsController@status')->name('status');

        Route::post('{gig}/pause', 'GigsController@pause')->name('pause');

        Route::delete('{gig}', 'GigsController@destroy')->name('destroy');
    });
});

