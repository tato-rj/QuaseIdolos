<?php

namespace App\Http\Controllers;

use App\Models\{Suggestion, Song};
use Illuminate\Http\Request;
use App\Mail\Users\SuggestionEmail;

class SuggestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suggestions = Suggestion::unconfirmed()->sortable()->get();

        return view('pages.suggestions.index', compact('suggestions'));
    }

    public function search(Request $request)
    {
        $artistQuery = Song::search($request->artist_name)->get();
        $songQuery = Song::search($request->song_name)->get();

        $songs = $artistQuery->intersect($songQuery);

        return $songs->count() ? view('pages.cardapio.components.suggestions.matches', compact('songs'))->render() : null;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'artist_name' => 'required', 
            'song_name' => 'required']);

        Suggestion::create([
            'user_id' => auth()->user()->id,
            'artist_name' => $request->artist_name,
            'song_name' => $request->song_name
        ]);

        return back()->with('success', 'Obrigado por envair a sua sugestão');
    }

    public function confirm(Suggestion $suggestion)
    {
        $suggestion->confirm();

        \Mail::to($suggestion->user->email)->queue(new SuggestionEmail($suggestion));

        return back()->with('success', 'A sugestão foi confirmada com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Suggestion  $suggestion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Suggestion $suggestion)
    {
        $suggestion->delete();

        return back()->with('success', 'A sugestão foi removida com sucesso');
    }
}
