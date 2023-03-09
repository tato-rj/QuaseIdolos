<div id="setlist"> 
	@forelse($show->setlist as $entry)
	@include('pages.shows.show.rows.setlist')
	@empty
	@include('components.empty')
	@endforelse
</div>

{{-- @table([
	'legend' => 'música|músicas',
	'rows' => $show->setlist,
	'empty' => true,
	'columns' => [
		'order' => 'Ordem', 
		'name*' => 'Nome', 
		'actions' => ''],
	'view' => 'pages.shows.show.rows.setlist'
]) --}}