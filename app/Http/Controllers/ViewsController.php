<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Artist, Genre, User};

class ViewsController extends Controller
{
    public function home()
    {
        $artists = Artist::inRandomOrder()->orderby('name')->take(10)->get();
        $genres = Genre::inRandomOrder()->orderby('name')->take(10)->get();
        $topUsers = User::ranking()->take(5)->get();

        $songs = collect();

        return view('pages.home.index', compact(['artists', 'genres', 'songs', 'topUsers']));
    }

    public function reservations()
    {
        return view('pages.reservas.index');
    }
}
