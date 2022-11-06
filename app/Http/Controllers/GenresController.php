<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;

class GenresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $genres = Genre::orderBy('name')->paginate(6);

        return view('pages.genres.index', compact('genres'));
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
            'name' => 'string|required|unique:genres',
            'image' => 'required'
        ]);

        Genre::create([
            'name' => $request->name,
            'slug' => str_slug($request->name),
            'image_path' => $request->file('image')->store('genres', 'public')
        ]);

        return back()->with('success', 'O estilo foi adicionado com sucesso');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Genre  $genre
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Genre $genre)
    {
        $request->validate([
            'name' => 'string|required',
        ]);

        $genre->update([
            'name' => $request->name,
            'slug' => str_slug($request->name),
        ]);

        if ($request->image) {
            $oldImage = $genre->image_path;
            $genre->update(['image_path' => $request->file('image')->store('genres', 'public')]);
            \Storage::disk('public')->delete($oldImage);
        }

        return redirect(route('genres.index'))->with('success', 'O estilo foi atualizado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Genre  $genre
     * @return \Illuminate\Http\Response
     */
    public function destroy(Genre $genre)
    {
        \Storage::disk('public')->delete($genre->image_path);
        $genre->songs->each->delete();
        $genre->delete();

        return redirect(route('genres.index'))->with('success', 'O estilo foi removido com sucesso');
    }
}
