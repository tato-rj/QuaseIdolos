<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Gig, Song};

class GigSongsController extends Controller
{
    public function search(Request $request, Gig $gig)
    {
        $songs = Song::search($request->input)->orderBy('name')->get();

        return view('pages.gigs.show.songs', compact(['songs', 'gig']))->render();
    }

    public function update(Request $request, Gig $gig, Song $song)
    {
        $list = collect($gig->excluded_songs ?? []);

        if ($list->contains($song->id)) {
            $list->forget($list->search($song->id));
        } else {
            $list->push($song->id);
        }

        $gig->update(['excluded_songs' => $list->values()]);
        
        return $gig->excluded_songs;
    }
}
