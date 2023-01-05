<?php

use Illuminate\Support\Facades\Route;

//////////////////
// GUEST ROUTES //
//////////////////

Route::get('', 'ViewsController@home')->withoutMiddleware('join-gig')->name('home');

Route::get('a-banda', 'ViewsController@about')->withoutMiddleware('join-gig')->name('about');

Route::get('reservas', 'ViewsController@reservations')->withoutMiddleware('join-gig')->name('reservas');

Route::prefix('auth/{driver}')->withoutMiddleware('join-gig')->group(function() {
    Route::get('redirect', 'Auth\SocialiteController@redirect')->name('socialite');

    Route::get('callback', 'Auth\SocialiteController@callback');
});

Route::prefix('cardapio')->withoutMiddleware('join-gig')->name('cardapio.')->group(function() {
    Route::get('', 'CardapioController@index')->name('index');
    
    Route::get('busca', 'CardapioController@search')->name('search');
});

Route::prefix('calendario')->withoutMiddleware('join-gig')->name('calendar.')->group(function() {
    Route::get('', 'CalendarController@index')->name('index');
});

/////////////////
// AUTH ROUTES //
/////////////////

Route::middleware('auth')->group(function() {
    Route::prefix('meu-perfil')->withoutMiddleware('join-gig')->name('profile.')->group(function() {
        Route::get('', 'UsersController@show')->name('show');

        Route::patch('{user?}', 'UsersController@update')->name('update');

        Route::post('senha/{user?}', 'UsersController@password')->name('password');

        Route::delete('{user?}', 'UsersController@destroy')->name('destroy');
    });

    Route::prefix('setlist')->name('setlists.')->group(function() {
        Route::get('', 'SetlistsController@user')->name('user');

        Route::get('alerta', 'SongRequestsController@alert')->name('alert');
    });

    Route::prefix('pedido-de-musica')->name('song-requests.')->group(function() {
        Route::post('{song}/enviar', 'SongRequestsController@store')->name('store');

        Route::patch('{songRequest}/mudar', 'SongRequestsController@update')->name('update');
        
        Route::delete('{id}/cancelar', 'SongRequestsController@cancel')->name('cancel');
    });

    Route::prefix('favoritos')->withoutMiddleware('join-gig')->name('favorites.')->group(function() {
        Route::get('', 'FavoritesController@index')->name('index');

        Route::post('{song}', 'FavoritesController@store')->name('store');

        Route::delete('{song}', 'FavoritesController@destroy')->name('destroy');
    });

    Route::prefix('eventos')->withoutMiddleware('join-gig')->name('gig.')->group(function() {
        Route::get('entrar', 'GigsController@select')->name('select');

        Route::patch('entrar/{gig}', 'GigsController@join')->name('join');

        Route::post('senha/{gig}', 'GigsController@verifyPassword')->name('verify-password');
    });

    Route::prefix('votacao')->name('ratings.')->group(function() {
        Route::get('', 'RatingsController@index')->name('index');

        Route::get('minhas-notas', 'RatingsController@user')->withoutMiddleware('join-gig')->name('user');

        Route::get('candidato', 'RatingsController@candidate')->name('candidate');
        
        Route::post('{songRequest}', 'RatingsController@store')->name('store');
    });

    Route::prefix('sugestoes')->withoutMiddleware('join-gig')->name('suggestions.')->group(function() {
        Route::post('', 'SuggestionsController@store')->name('store');
    });

});

//////////////////
// ADMIN ROUTES //
//////////////////

Route::middleware('admin')->group(function() {
    Route::prefix('cantores')->withoutMiddleware('join-gig')->name('users.')->group(function() {
        Route::get('', 'UsersController@index')->name('index');

        Route::get('{user}/editar', 'UsersController@edit')->name('edit');
    });

    Route::prefix('artistas')->withoutMiddleware('join-gig')->name('artists.')->group(function() {
        Route::get('', 'ArtistsController@index')->name('index');

        Route::get('buscar', 'ArtistsController@search')->name('search');

        Route::get('{artist}/editar', 'ArtistsController@edit')->name('edit');

        Route::patch('{artist}', 'ArtistsController@update')->name('update');

        Route::post('salvar', 'ArtistsController@store')->name('store');

        Route::delete('{artist}', 'ArtistsController@destroy')->name('destroy');
    });

    Route::prefix('musicas')->withoutMiddleware('join-gig')->name('songs.')->group(function() {
        Route::get('', 'SongsController@index')->name('index');

        Route::get('buscar', 'SongsController@search')->name('search');

        Route::get('{song}/editar', 'SongsController@edit')->name('edit');

        Route::patch('{song}', 'SongsController@update')->name('update');

        Route::post('salvar', 'SongsController@store')->name('store');

        Route::delete('{song}', 'SongsController@destroy')->name('destroy');
    });

    Route::prefix('pedido-de-musica')->name('song-requests.')->group(function() {
        Route::post('{songRequest}/confirmar', 'SongRequestsController@finish')->name('finish');
    });


    Route::prefix('sugestoes')->withoutMiddleware('join-gig')->name('suggestions.')->group(function() {
        Route::get('', 'SuggestionsController@index')->name('index');

        Route::post('{suggestion}', 'SuggestionsController@confirm')->name('confirm');

        Route::delete('{suggestion}', 'SuggestionsController@destroy')->name('destroy');
    });

    Route::prefix('letra')->withoutMiddleware('join-gig')->name('lyrics.')->group(function() {
        Route::get('', 'LyricsController@index')->name('index');

        Route::get('busca', 'LyricsController@search')->name('search');
        
        Route::post('{songRequest}', 'LyricsController@get')->name('get');
    });

    Route::prefix('setlist')->name('setlists.')->group(function() {
        Route::get('admin', 'SetlistsController@admin')->name('admin');

        Route::get('tabela', 'SetlistsController@table')->name('table');
    });

    Route::prefix('estilos')->withoutMiddleware('join-gig')->name('genres.')->group(function() {
        Route::get('', 'GenresController@index')->name('index');

        Route::post('', 'GenresController@store')->name('store');

        Route::patch('{genre}', 'GenresController@update')->name('update');

        Route::delete('{genre}', 'GenresController@destroy')->name('destroy');
    });

    Route::prefix('votacao')->name('ratings.')->group(function() {
        Route::get('ao-vivo', 'RatingsController@live')->name('live');

        Route::get('votos', 'RatingsController@votes')->name('votes');

        Route::prefix('vencedor')->name('winner.')->group(function() {
            Route::get('', 'WinnersController@show')->name('show');

            Route::get('anunciar', 'WinnersController@broadcast')->name('broadcast');
        });
    });
});

////////////////////////
// SUPER ADMIN ROUTES //
////////////////////////

Route::middleware('super-admin')->group(function() {
    Route::prefix('equipe')->withoutMiddleware('join-gig')->name('team.')->group(function() {
        Route::get('', 'TeamController@index')->name('index');

        Route::get('busca', 'TeamController@search')->name('search');

        Route::patch('{user}', 'TeamController@update')->name('update');
    });

    Route::prefix('usuarios')->withoutMiddleware('join-gig')->name('users.')->group(function() {
        Route::get('busca', 'UsersController@search')->name('search');
    });

    Route::prefix('contratantes')->name('venues.')->withoutMiddleware('join-gig')->group(function() {
        Route::get('', 'VenuesController@index')->name('index');

        Route::prefix('{venue}')->name('show.')->group(function() {
            Route::get('hoje', 'VenuesController@today')->name('today');

            Route::get('passado', 'VenuesController@past')->name('past');
            
            Route::get('futuro', 'VenuesController@upcoming')->name('upcoming');
        });

        Route::post('', 'VenuesController@store')->name('store');

        Route::patch('{venue}', 'VenuesController@update')->name('update');

        Route::delete('{venue}', 'VenuesController@destroy')->name('destroy');
    });

    Route::prefix('eventos')->name('gig.')->withoutMiddleware('join-gig')->group(function() {
        Route::get('', 'GigsController@index')->name('index');

        Route::get('{gig}', 'GigsController@show')->name('show');

        Route::get('{gig}/senha', 'GigsController@password')->name('password');

        Route::post('', 'GigsController@store')->name('store');

        Route::patch('{gig}', 'GigsController@update')->name('update');

        Route::patch('{gig}/password', 'GigsController@updatePassword')->name('update-password');

        Route::post('{gig}/duplicar', 'GigsController@duplicate')->name('duplicate');

        Route::post('{gig}/abrir', 'GigsController@open')->name('open');

        Route::post('{gig}/fechar', 'GigsController@close')->name('close');

        Route::post('{gig}/pausar', 'GigsController@pause')->name('pause');

        Route::delete('{gig}', 'GigsController@destroy')->name('destroy');
    });

    Route::prefix('emails')->name('mail.')->withoutMiddleware('join-gig')->group(function() {
        Route::get('{mail}', 'MailController@preview');
    });

    Route::prefix('estatisticas')->name('stats.')->withoutMiddleware('join-gig')->group(function() {
        Route::get('eventos', 'StatsController@gigs')->name('gigs');

        Route::get('artistas', 'StatsController@artists')->name('artists');

        Route::get('estilos', 'StatsController@genres')->name('genres');
    });
});

