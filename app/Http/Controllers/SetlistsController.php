<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Gig, SongRequest};

class SetlistsController extends Controller
{
    public function show()
    {
        $gig = Gig::live()->first();
        $setlist = SongRequest::waiting()->get();

        return view('pages.song-requests.live', compact(['setlist', 'gig']));
    }
}
