<div class="row"> 
	<div class="col-lg-8 col-12 mx-auto">
		<div id="setlist"> 
			@foreach($setlist->whereNull('finished_at') as $entry)
			@include('pages.setlists.admin.songRequests.small')
			@endforeach
		</div>
	</div>
</div>