<div>
	@include('pages.setlists.admin.counter')

	<div id="setlist"> 
		@forelse($setlist->whereNull('finished_at') as $entry)
		@include('pages.setlists.admin.song-request')
		@empty
		@include('components.empty')
		@endforelse
	</div>

	@if(! $setlist->whereNotNull('finished_at')->isEmpty())
	<div class="mt-5 pt-4" style="border-top: 8px dotted rgba(0,0,0,0.2)">
		<h5 class="text-center mb-4">Músicas já cantadas</h5>
		@foreach($setlist->whereNotNull('finished_at')->reverse() as $entry)
		@include('pages.setlists.admin.confirmed')
		@endforeach
	</div>
	@endif
</div>