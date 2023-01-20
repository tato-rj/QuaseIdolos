<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{User, Suggestion, Favorite, SongRequest, Rating, Participant, SocialAccount};

class DebugController extends Controller
{
    public function index()
    {
        dd('here');
        // return view('debug.index');

        foreach (SocialAccount::all() as $item) {
            if (! $item->user)
                dd($item->id . ' is missing the user!');
        }
    }
}
