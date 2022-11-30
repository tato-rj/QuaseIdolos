<div class="table-row">
	<div class="row mx-auto py-3 align-items-center container">
		<div class="col-12 row">
			<div class="col-3 text-truncate">
				<div class="d-flex align-items-center">
					<form method="POST" action="{{route('gig.duplicate', $gig)}}">
						@csrf
						<button class="btn-raw">@fa(['icon' => 'copy', 'fa_color' => 'white'])</button>
					</form>
					<a href="{{route('gig.edit', $gig)}}" class="link-secondary fw-bold d-block"><h5 class="m-0">{{$gig->dateForHumans}}</h5></a>
				</div>
			</div>
			<div class="col-3 text-truncate">
				<p class="m-0">{{$gig->participants()->count()}}</p>
			</div>
			<div class="col-3 text-truncate">
				<p class="m-0">{{$gig->setlist()->completed()->count()}}</p>
			</div>
			<div class="col-3 text-truncate">
				<p class="m-0">{!! $gig->status !!}</p>
			</div>
		</div>
	</div>
</div>