<?php

namespace App\Archives;

use Illuminate\Database\Eloquent\Model;
use App\Models\{Gig, Song, User};
use App\Archives\Models\{GigArchives, SongArchives, UserArchives};

class Archives
{
	protected $models = [
		Gig::class => GigArchives::class,
		Song::class => SongArchives::class,
		User::class => UserArchives::class
	];

	public function for(Model $model)
	{
		if (! array_key_exists($model::class, $this->models))
			abort('The ' . $model::class . ' does not have any archives.');

		$archives = $this->models[$model::class];

		return new $archives($model);
	}
}