@php($gig = $row)

@row
  @slot('column1')
		<div class="d-flex align-items-center">
			<form method="POST" action="{{route('gig.duplicate', $gig)}}">
				@csrf
				<button class="btn-raw">@fa(['icon' => 'copy', 'fa_color' => 'white'])</button>
			</form>
			<a href="{{route('gig.edit', $gig)}}" class="link-secondary fw-bold d-block">{{$gig->name()}}</a>
		</div>
		<div class="d-md-none m-0">{{$gig->dateInContext}}</div>
  @endslot

  @slot('column2')
  {{$gig->dateInContext}}
  @endslot

  @slot('column3')
  {{$gig->setlist()->completed()->count()}}
  @endslot

  @slot('column4')
  {!! $gig->status !!}
  @endslot

  @slot('actions')
		@if($gig->isLive())
		<button class="pause-switch btn btn-sm btn-secondary mr-2" data-url="{{route('gig.pause', $gig)}}">
		  @fa(['icon' => $gig->is_paused ? 'play' : 'pause', 'mr' => 0])
		</button>
		@endif

		@if($gig->isLive())
		<button data-bs-toggle="modal" data-bs-target="#close-gig-{{$gig->id}}-modal" class="btn btn-red btn-sm text-nowrap">Fechar</button>
		@include('pages.gigs.modals.close')
		@else
		<form method="POST" action="{{route('gig.open', $gig)}}">
			@csrf
			<button class="btn btn-secondary btn-sm text-nowrap">Abrir</button>
		</form>
		@endif
  @endslot
@endrow