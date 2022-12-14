<div class="artists-container" style="display: {{$songs->count() ? 'none' : 'block'}}">
	<div class="d-center flex-wrap"> 
		@foreach($artists as $artist)
		<a href="{{route('cardapio.index', ['artista' => $artist])}}" class="link-none">
		@include('pages.cardapio.components.artist.avatar')
		</a>
		@endforeach
	</div>
	@isset($withlinks)
	{{$artists->links()}}
	@endisset
</div>