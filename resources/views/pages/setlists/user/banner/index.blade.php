<div id="setlist-banner" class="position-fixed bottom-0 left-0 w-100 animate__animated animate__fadeInUp" style="background: rgba(255,255,255,0.8);">
	<div class="bg-secondary p-1 text-center">
		{{-- <h6 class="m-0 text-red no-stroke"><small>{!! $songRequests->first()->position(true) !!}</small></h6> --}}
		@php($order = $songRequests->first()->order)
		<h6 class="m-0 text-red no-stroke">
			<small>
				@if($order >= 1)
				@choice(__('views/songRequest.banner.faltam'), $order) {{$order}} @choice(__('plurais.música'), $order)
				@else
				@lang('views/songRequest.banner.your-turn')
				@endif
			</small>
		</h6>
	</div>
	@if($songRequests->count() == 1)
	@include('pages.setlists.user.banner.song', ['songRequest' => $songRequests->first()])
	@else
	@include('pages.setlists.user.banner.songs')
	@endif
</div>

@foreach($songRequests as $songRequest)
@if($songRequest->user->is(auth()->user()))
	@include('pages.song-requests.modals.cancel', ['entry' => $songRequest])
	@include('pages.song-requests.modals.change', ['entry' => $songRequest])
	@modal(['title' => 'Enviar um convite', 'id' => 'guest-invite-modal'])
	@include('pages.participants.invite', ['songRequest' => $songRequest])
	@endmodal
	@else
	@include('pages.song-requests.modals.decline', ['entry' => $songRequest])
@endif
@endforeach


