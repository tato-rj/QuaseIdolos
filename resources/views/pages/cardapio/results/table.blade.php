<div class="mt-">
	@unless($songs->isEmpty())
	<h6 id="clear-results" class="text-center mb-3 cursor-pointer">@fa(['icon' => 'eraser'])limpar pesquisa</h6>
	@endunless
	@foreach($songs as $song)
	@include('pages.cardapio.results.row')
	@endforeach
</div>