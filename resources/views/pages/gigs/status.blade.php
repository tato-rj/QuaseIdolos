	<div class="row">
		<div class="col-12">
			<div class="d-apart w-100 rounded-pill py-2 px-3 mb-4" style="background: rgba(255,255,255,0.1);">
				<div>
					<div class="fw-bold  text-nowrap">
						{!! $gig->status !!}
					</div>
				</div>
				@if($gig->isReady())
				<div class="d-center gig-controls">
					
					<button class="pause-switch d-center btn rounded-circle btn-secondary {{$gig->is_live ? null : 'd-none'}}" data-url="{{route('gig.pause', $gig)}}">
					  @fa(['icon' => $gig->is_paused ? 'play' : 'pause', 'mr' => 0])
					</button>

					@toggle(['name' => 'is_live', 'on' => $gig->is_live, 'url' => route('gig.status', $gig)])
					
				</div>
				@endif
			</div>
		</div>
	</div>