<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{User, Song};

class UnknownSongsController extends Controller
{
    public function search(Request $request, User $user)
    {
        $songs = Song::search($request->input)->orderBy('name')->get();

        return view('pages.team.songs', compact(['songs', 'user']))->render();
    }

    public function update(Request $request, User $user, Song $song)
    {
        $list = collect($user->admin->unknown_songs ?? []);

        if ($list->contains($song->id)) {
            $list->forget($list->search($song->id));
        } else {
            $list->push($song->id);
        }

        $user->admin->update(['unknown_songs' => $list->isNotEmpty() ? $list->values() : null]);
        
        return $user->admin->unknown_songs;
    }
}
