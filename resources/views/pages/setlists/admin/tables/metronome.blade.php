<div class="row mb-4"> 
	<div class="col-lg-8 col-12 mx-auto">
		<div id="setlist" class="border border-secondary rounded" style="max-height: 300px; overflow-y: scroll;"> 
			@forelse($setlist->whereNull('finished_at') as $entry)
			@include('pages.setlists.admin.songRequests.metronome')
			@empty
			@include('components.empty')
			@endforelse
		</div>
	</div>
</div>