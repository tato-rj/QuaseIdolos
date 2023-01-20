<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Status\AppStatus;
use App\Models\{User, Suggestion, Favorite, SongRequest, Rating, Participant, SocialAccount, Song, Artist, Gig};

class StatusController extends Controller
{
    public function index()
    {
        $users = (new AppStatus(User::class))->hasMany([
            Suggestion::class,
            Favorite::class, 
            SongRequest::class,
            Participant::class, 
            SocialAccount::class])->check();

        $songRequests = (new AppStatus(SongRequest::class))->belongsTo([
            Gig::class, 
            User::class,
            Song::class])->check();

        $songs = (new AppStatus(Song::class))->hasMany([
            Favorite::class, 
            SongRequest::class])->belongsTo([Artist::class])->check();

        $artists = (new AppStatus(Artist::class))->hasMany([
            Song::class])->check();

        $report = collect([
            User::class => $users,
            SongRequest::class => $songRequests,
            Song::class => $songs,
            Artist::class => $artists
        ]);

        return view('status.index', compact(['report']));
    }
}
