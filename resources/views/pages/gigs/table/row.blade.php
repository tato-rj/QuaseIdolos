<div class="table-row">
	<div class="row mx-auto py-3 align-items-center">
		<div class="col-lg-10 col-md-10 col-9 row">
			<div class="col-lg-3 col-md-3 col-6 text-truncate">
				<div class="d-flex align-items-center">
					<form method="POST" action="{{route('gig.duplicate', $gig)}}">
						@csrf
						<button class="btn-raw">@fa(['icon' => 'copy', 'fa_color' => 'white'])</button>
					</form>
					<a href="{{route('gig.edit', $gig)}}" class="link-secondary fw-bold d-block" style="font-size: 1.2rem"><h5 class="m-0">{{$gig->name}}</h5></a>
				</div>
				<p class="{{$ready ? null : 'opacity-6'}} d-md-none m-0">{{$gig->dateForHumans ?? 'Diário'}}</p>
			</div>
			<div class="col-lg-3 col-md-3 d-none d-md-block text-truncate">
				<p class="{{$ready ? null : 'opacity-6'}} m-0">{{$gig->dateForHumans ?? 'Diário'}}</p>
			</div>
			<div class="col-lg-3 col-md-3 d-none d-md-block text-truncate">
				<p class="{{$ready ? null : 'opacity-6'}} m-0">{{$gig->setlist()->completed()->count()}}</p>
			</div>
			<div class="col-lg-3 col-md-3 col-6 text-truncate">
				<p class="{{$ready ? null : 'opacity-6'}} m-0">{!! $gig->status !!}</p>
			</div>
		</div>

		<div class="col-lg-2 col-md-2 col-3 text-right d-flex justify-content-end ">
			@if($ready)		
				@if($gig->isLive())
				<button class="pause-switch d-center btn rounded-circle btn-secondary" data-url="{{route('gig.pause', $gig)}}">
				  @fa(['icon' => $gig->is_paused ? 'play' : 'pause', 'mr' => 0])
				</button>
				@endif

				@toggle(['name' => 'is_live', 'on' => $gig->is_live, 'url' => route('gig.status', $gig)])
			@endif
		</div>
	</div>
</div>