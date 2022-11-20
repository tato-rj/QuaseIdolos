<div class="artists-container" style="display: {{$songs->count() ? 'none' : 'block'}}">
	<div class="d-center flex-wrap"> 
		@foreach($artists as $artist)
		<a href="{{route('cardapio.index', ['input' => strtolower($artist->name)])}}" class="link-none">
		@include('pages.cardapio.components.artist.avatar')
		</a>
		@endforeach
	</div>
	{{$artists->links()}}
</div>