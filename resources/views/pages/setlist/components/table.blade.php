<div class="row">
	@if($setlist->count())
		<h5 class="mb-3 text-center">{{$setlist->count()}} @choice('música|músicas', $setlist->count()) na lista</h5>
	@endif
	@forelse($setlist as $entry)
	@include('pages.setlist.components.request')
	@empty
	@include('components.empty', ['message' => 'Este setlist está vazio...'])
	@endforelse
</div>