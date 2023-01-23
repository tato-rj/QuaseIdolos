<div class="row"> 
	<div class="col-lg-8 col-12 mx-auto">
		<div id="setlist"> 
			@forelse($setlist->whereNull('finished_at') as $entry)
			@include('pages.setlists.admin.songRequests.small')
			@empty
			@include('components.empty')
			@endforelse
		</div>
	</div>
</div>