@if(auth()->check() && auth()->user()->setlists()->waitingFor($song)->exists())
<button class="btn btn-secondary text-truncate w-100 mb-3">@fa(['icon' => 'check'])JÁ ESTÁ NA FILA</button>
@else
<form method="POST" action="{{route('setlist.store', $song)}}" data-trigger="loader">
	@csrf
	<button class="btn btn-secondary text-truncate w-100 mb-3">@fa(['icon' => 'microphone'])CANTAR</button>
</form>
@endif

@if(auth()->check() && auth()->user()->favorited($song)->exists())
<form method="POST" action="{{route('favorites.destroy', $song)}}" data-trigger="loader">
	@csrf
	@method('DELETE')
	<button class="btn btn-outline-secondary text-truncate w-100">@fa(['icon' => 'heart'])REMOVER DOS FAVORITOS</button>
</form>		
@else
<form method="POST" action="{{route('favorites.store', $song)}}" data-trigger="loader">
	@csrf
	<button class="btn btn-outline-secondary text-truncate w-100">@fa(['icon' => 'heart'])SALVAR PRA DEPOIS</button>
</form>
@endif