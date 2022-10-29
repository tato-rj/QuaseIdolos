<div>
	@if($setlist->count())
		<h5 class="mb-3 text-center">{{$setlist->count()}} @choice('música|músicas', $setlist->count()) na lista</h5>
	@endif

	<div id="setlist"> 
		@foreach($setlist as $entry)
		@include('pages.setlists.admin.song-request')
		@endforeach
	</div>

	@if($setlist->isEmpty())
	@include('components.empty')
	@endif
</div>