<?php

use Illuminate\Support\Facades\Route;

Route::get('', function () {
    return view('pages.home.index');
})->name('home');

Route::get('cardapio', 'CardapioController@index')->name('cardapio');

Route::prefix('cardapio')->name('cardapio.')->group(function() {
    Route::get('artist/{artist}', 'CardapioController@byArtist')->name('artist');
    
    Route::get('search', 'CardapioController@search')->name('search');
});

Route::middleware('admin')->prefix('artists')->name('artists.')->group(function() {
    Route::get('', 'ArtistsController@index')->name('index');

    Route::get('{artist}/edit', 'ArtistsController@edit')->name('edit');

    Route::patch('{artist}', 'ArtistsController@update')->name('update');

    Route::post('store', 'ArtistsController@store')->name('store');

    Route::delete('{artist}', 'ArtistsController@destroy')->name('destroy');
});

Route::middleware('admin')->prefix('songs')->name('songs.')->group(function() {
    Route::get('', 'SongsController@index')->name('index');

    Route::get('{song}/edit', 'SongsController@edit')->name('edit');

    Route::patch('{song}', 'SongsController@update')->name('update');

    Route::post('store', 'SongsController@store')->name('store');

    Route::delete('{song}', 'SongsController@destroy')->name('destroy');
});

Route::middleware('admin')->prefix('setlist')->name('setlist.')->group(function() {
    Route::get('', 'SetlistController@live')->name('live');

    Route::post('{request}/finish', 'SetlistController@finish')->name('finish');
});

Route::middleware('auth')->prefix('setlist')->name('setlist.')->group(function() {
    Route::get('alert', 'SetlistController@alert')->name('alert');

    Route::post('{song}', 'SetlistController@store')->name('store');
    
    Route::delete('{request}/cancel', 'SetlistController@cancel')->name('cancel');
});

