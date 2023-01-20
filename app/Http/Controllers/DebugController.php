<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{User, Suggestion, Favorite, SongRequest, Rating, Participant};

class DebugController extends Controller
{
    public function index()
    {
        foreach (Participant::all() as $item) {
            if (! $item->user)
                dd($item->id . ' is missing the user!');
        }
    }
}
