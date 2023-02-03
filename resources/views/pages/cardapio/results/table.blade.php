@php($gigCount = \App\Models\Gig::ready()->count())

@unless($songs->isEmpty())
<div class="text-center">
	<button id="clear-results" class="btn btn-secondary mb-3">@fa(['icon' => 'eraser'])@lang('views/cardapio.reset-btn')</button>
</div>
@endunless

@table([
	'legend' => 'música|músicas',
	'rows' => $songs,
	'view' => 'pages.cardapio.results.row'
])
