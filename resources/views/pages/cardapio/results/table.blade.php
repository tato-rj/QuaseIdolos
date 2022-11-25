@php($gigCount = \App\Models\Gig::ready()->count())
<div class="mt-">
	@unless($songs->isEmpty())
	<div class="text-center">
		<button id="clear-results" class="btn btn-secondary mb-3">@fa(['icon' => 'eraser'])limpar pesquisa</button>
	</div>
	@endunless
	@foreach($songs as $song)
	@include('pages.cardapio.results.row')
	@endforeach
</div>