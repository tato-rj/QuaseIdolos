<div id="artists-container" style="display: {{$songs->count() ? 'none' : 'block'}}">

	<div class="px-4">
		<h3 class="opacity-4 text-white no-stroke border-3 border-bottom mb-2 pb-2" style="border-color: rgba(255,255,255,0.1)">0-10</h3>
	</div>
	<div class="d-flex flex-wrap"> 
			@foreach($artists->first() as $artist)
			<a href="{{route('cardapio.index', ['input' => strtolower($artist->name)])}}" class="link-none">
			@include('pages.cardapio.components.artist.avatar')
			</a>
			@endforeach
	</div>

	@foreach(range('A', 'Z') as $index => $letter)
		@isset($artists[$index + 1])
		<div class="px-4">
			<h3 class="opacity-4 text-white no-stroke border-3 border-bottom mb-2 pb-2" style="border-color: rgba(255,255,255,0.1)">{{$letter}}</h3>
		</div>
		<div class="d-flex flex-wrap"> 
				@foreach($artists[$index + 1] as $artist)
				<a href="{{route('cardapio.index', ['input' => strtolower($artist->name)])}}" class="link-none">
				@include('pages.cardapio.components.artist.avatar')
				</a>
				@endforeach
		</div>
		@endisset
	@endforeach

</div>