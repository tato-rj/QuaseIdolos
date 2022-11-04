<div>
	@include('pages.setlists.admin.counter')

	<div id="setlist"> 
		@foreach($setlist as $entry)
		@include('pages.setlists.admin.song-request')
		@endforeach
	</div>

	@if($setlist->isEmpty())
	@include('components.empty')
	@endif
</div>