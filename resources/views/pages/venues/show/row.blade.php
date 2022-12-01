@php($gig = $row)

@row
  @slot('column1')
		<div class="d-flex align-items-center">
			<form method="POST" action="{{route('gig.duplicate', $gig)}}">
				@csrf
				<button class="btn-raw">@fa(['icon' => 'copy', 'fa_color' => 'white'])</button>
			</form>
			<a href="{{route('gig.edit', $gig)}}" class="link-secondary fw-bold d-block"><h5 class="m-0">{{$gig->dateForHumans}}</h5></a>
		</div>
  @endslot

  @slot('column2')
  {{$gig->participants()->count()}}
  @endslot

  @slot('column3')
  {{$gig->setlist()->completed()->count()}}
  @endslot

  @slot('column4')
  {!! $gig->status !!}
  @endslot
@endrow