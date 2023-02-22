@php($gig = $row)

@switch(str_replace('*', '', $field))
  @case('event')
		<div class="d-flex align-items-center">
			{!! $gig->status()->noText()->get() !!}
			<form method="POST" action="{{route('gig.duplicate', $gig)}}">
				@csrf
				<button class="btn-raw" style="vertical-align: sub;">@fa(['icon' => 'copy', 'fa_color' => 'white'])</button>
			</form>
			<a href="{{route('gig.show', $gig)}}" class="link-secondary fw-bold d-block mr-3 h5 mb-0">
				{{$gig->name()}}
				@if($gig->password()->required())
				<span class="ml-1 opacity-6 text-white rounded-pill bg-transparent px-2 py-1">@fa(['icon' => 'key', 'fa_size' => 'xs', 'fa_color' => 'secondary']){{$gig->password}}</span>
				@endif
			</a>
		</div>
      @break

  @case('status')
	  {{$gig->status()->onlyText()->get()}}
      @break

  @case('actions')
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
      @break
@endswitch