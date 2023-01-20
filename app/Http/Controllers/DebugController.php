<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{User, Suggestion, Favorite, SongRequest, Rating};

class DebugController extends Controller
{
    public function index()
    {
        return User::all();
    }
}
