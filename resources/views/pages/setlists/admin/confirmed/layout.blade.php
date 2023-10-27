{{-- <div class="row">
	<div class="col-lg-8 col-md-10 col-10 mx-auto">
	<div class="d-flex flex-wrap">
		@foreach($setlist->whereNotNull('finished_at')->sortBy('finished_at') as $entry)
		@include('pages.setlists.admin.confirmed.avatars')
		@endforeach
	</div>
</div> --}}
@foreach($setlist->whereNotNull('finished_at')->sortByDesc('finished_at') as $entry)
@include('pages.setlists.admin.confirmed.complete')
@endforeach