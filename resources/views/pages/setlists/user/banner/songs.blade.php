<div class="row" id="toggle-waiting-list" data-target="#waiting-list-banner">
	<div class="col-lg-6 col-md-10 col-12 mx-auto py-2">
		<div class="d-apart px-2">
			<div class="text-truncate">
				<h6 class="text-primary m-0 no-stroke">{{$songRequests->count()}} Pedidos na lista</h6>
			</div>

			<button class="btn btn-secondary">@fa(['icon' => 'chevron-up', 'mr' => 0])</button>
		</div>
	</div>
</div>

<div id="waiting-list-banner" style="display: none;">
	@foreach($songRequests as $songRequest)
	@include('pages.setlists.user.banner.song')
	@endforeach
</div>