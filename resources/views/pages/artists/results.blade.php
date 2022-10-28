<h5 class=" ml-5">Total de {{$artists->count()}} @choice('artista|artistas', $artists->count())</h5>
<div class="d-flex justify-content-center flex-wrap"> 
	@foreach($artists as $artist)
	<a href="{{route('artists.edit', $artist)}}" class="link-none">
		@include('pages.cardapio.components.artist.avatar')
	</a>
	@endforeach
</div>
