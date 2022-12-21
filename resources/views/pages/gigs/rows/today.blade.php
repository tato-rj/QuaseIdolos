@php($gig = $row)

@row(['optional' => $optional ?? []])
  @slot('column1')
		<div class="d-flex align-items-center">
			{!! $gig->status()->noText()->get() !!}
			<form method="POST" action="{{route('gig.duplicate', $gig)}}">
				@csrf
				<button class="btn-raw" style="vertical-align: sub;">@fa(['icon' => 'copy', 'fa_color' => 'white'])</button>
			</form>
			<a href="{{route('gig.show', $gig)}}" class="link-secondary fw-bold d-block mr-3 h5 mb-0">{{$gig->name()}}</a>
		</div>
  @endslot

  @slot('column2')
  {{$gig->status()->onlyText()->get()}}
  @endslot

  @slot('actions')
		@if($gig->isLive())

{{-- 		<button class="pause-switch btn btn-sm btn-secondary mr-2" data-url="{{route('gig.pause', $gig)}}">
		  @fa(['icon' => $gig->is_paused ? 'play' : 'pause', 'mr' => 0])
		</button> --}}
		@endif

		@if($gig->isLive())
		<form method="POST" action="{{route('gig.pause', $gig)}}" class="d-inline mr-2">
			@csrf
			<button type="submit" class="btn btn-sm btn-secondary">
			  @fa(['icon' => $gig->isPaused() ? 'play' : 'pause', 'mr' => 0])
			</button>
		</form>
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