<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use Illuminate\Http\Request;

class ArtistsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $artists = Artist::sortable('name', 'ASC')->paginate(12);

        return view('pages.artists.index', compact('artists'));
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
            'name' => 'string|required|unique:artists',
            'image' => 'required|max:200|mimes:jpg,jpeg'
        ]);

        Artist::create([
            'name' => $request->name,
            'slug' => str_slug($request->name),
            'is_hidden' => $request->has('is_hidden'),
            'image_path' => $request->file('image')->store('artists', 'public')
        ]);

        return back()->with('success', 'O artista foi adicionado com sucesso');
    }

    public function search(Request $request)
    {
        $artists = $request->input ? Artist::search($request->input)->orderBy('name')->get() : null;

        return $artists ? view('pages.artists.results', compact('artists'))->render() : null;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Artist  $artist
     * @return \Illuminate\Http\Response
     */
    public function edit(Artist $artist)
    {
        return view('pages.artists.edit.index', compact('artist'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Artist  $artist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Artist $artist)
    {
        $request->validate([
            'name' => 'string|required',
            'image' => 'sometimes|max:200|mimes:jpg,jpeg'
        ]);

        $artist->update([
            'name' => $request->name,
            'slug' => str_slug($request->name),
            'is_hidden' => $request->has('is_hidden')
        ]);

        if ($request->image) {
            $oldImage = $artist->image_path;
            $artist->update(['image_path' => $request->file('image')->store('artists', 'public')]);
            \Storage::disk('public')->delete($oldImage);
        }

        return redirect(route('artists.edit', $artist))->with('success', 'O artista foi atualizado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Artist  $artist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Artist $artist)
    {
        \Storage::disk('public')->delete($artist->image_path);
        $artist->songs->each->delete();
        $artist->delete();

        return redirect(route('artists.index'))->with('success', 'O artista foi removido com sucesso');
    }
}
