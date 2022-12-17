<a href="{{route('cardapio.index', ['estilo' => $genre->slug])}}" class="link-none">
	<div class="rounded py-2 position-relative d-center m-2">
		<h4 class="m-0 text-truncate position-absolute-center w-100 text-center px-2">{{$genre->name}}</h4>
		<div class="bg-center position-relative rounded" style="background-image: url({{$genre->coverImage()}}); width: 160px; height: 75px; z-index: -1;">
			<div class="bg-black opacity-4 position-absolute w-100 h-100 top-0 left-0 rounded"></div>
		</div>
	</div>
</a>
