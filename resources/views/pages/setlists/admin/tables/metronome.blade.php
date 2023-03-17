<div class="row mb-4" id="setlist"> 
	<div class="col-lg-8 col-12 mx-auto">
		<p class="fw-bold opacity-6 text-center">Escolha a música para ligar o metrônomo</p>
		<div class="border border-secondary rounded" style="max-height: 300px; overflow-y: scroll;"> 
			@forelse($setlist->whereNull('finished_at') as $entry)
			@include('pages.setlists.admin.songRequests.metronome')
			@empty
			@include('components.empty')
			@endforelse
		</div>
	</div>
</div>