@if(hasPagination($artists))
<h5 class="mb-3">Mostrando {{$artists->firstItem()}} a {{$artists->lastItem()}} de {{$artists->total()}} @choice('artista|artistas', $artists->count())</h5>
@else
<h5 class="mb-3">Mostrando {{$artists->count()}} @choice('artista|artistas', $artists->count())</h5>
@endif

<div class="d-flex justify-content-center flex-wrap"> 
	@foreach($artists as $artist)
	<a href="{{route('artists.edit', $artist)}}" class="link-none">
		@include('pages.cardapio.components.artist.avatar')
	</a>
	@endforeach
</div>

