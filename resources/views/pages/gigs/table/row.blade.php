<div class="table-row">
	<div class="row mx-auto py-3 align-items-center">
		<div class="col-lg-10 col-md-10 col-9 row">
			<div class="col-lg-4 col-md-4 col-6 text-truncate">
				<a href="{{route('gig.show', $gig)}}" class="link-secondary fw-bold d-block" style="font-size: 1.2rem">{{$gig->name}}</a>
				<strong class="opacity-6 d-md-none">{{$gig->date->format('j/n/y')}}</strong>
			</div>
			<div class="col-lg-4 col-md-4 d-none d-md-block text-truncate">
				<strong class="opacity-6">{{$gig->date->format('j/n/y')}}</strong>
			</div>
			<div class="col-lg-4 col-md-4 col-6 text-truncate">
				<strong class="opacity-6">{!! $gig->status !!}</strong>
			</div>
		</div>

		<div class="col-lg-2 col-md-2 col-3 text-right d-flex justify-content-end gig-controls">
			@if($gig->ready() && ! $gig->isOver)		
				<button class="pause-switch d-center btn rounded-circle btn-secondary {{$gig->is_live ? null : 'd-none'}}" data-url="{{route('gig.pause', $gig)}}">
				  @fa(['icon' => $gig->is_paused ? 'play' : 'pause', 'mr' => 0, 'fa_size' => 'lg'])
				</button>

				@toggle(['name' => 'is_live', 'on' => $gig->is_live, 'url' => route('gig.status', $gig)])
			@endif
		</div>
	</div>
</div>