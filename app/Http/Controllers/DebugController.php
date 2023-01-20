<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{User, Suggestion, Favorite, SongRequest, Rating};

class DebugController extends Controller
{
    public function index()
    {
        foreach (Suggestion::all() as $item) {
            if (! $item->user)
                dd($item->id . ' is missing the user!');
        }
    }
}
