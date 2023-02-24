<?php

namespace App\Models\Traits;

use Illuminate\Http\Request;

trait Cardapio
{
	public function scopeCardapio($query, Request $request)
	{
        if ($request->has('input')) {
            return $query->search($request->input);
        } elseif ($request->has('artista')) {
			return $query->byArtist($request->artista);
        } elseif ($request->has('estilo')) {
            return $query->byGenre($request->estilo);
        }

        return $query->where('id', $request->musica);
	}

	public function scopeSearch($query, $input)
	{
		return $query
			->where(function($q) use ($input) {
				$q->where('name', 'LIKE', '%'.$input.'%');
				$q->orWhereHas('genre', function($q) use ($input) {
					$q->where('name', 'LIKE', '%'.$input.'%');
				});
				$q->orWhereHas('artist', function($q) use ($input) {
					$q->where('name', 'LIKE', '%'.$input.'%');
				});
			})->visibleArtist();
	}
}