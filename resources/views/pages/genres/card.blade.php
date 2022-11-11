<a href="{{route('cardapio.index', ['input' => strtolower($genre->name)])}}" class="link-none">
	<div class="rounded py-2 bg-center position-relative d-center m-2" style="background-image: url({{$genre->coverImage()}}); width: 160px; height: 75px;">
		<div class="bg-black opacity-4 position-absolute w-100 h-100 top-0 left-0 rounded" style="z-index: 1"></div>
		<h4 class="m-0 text-truncate" style="z-index: 2">{{$genre->name}}</h4>
	</div>
</a>
