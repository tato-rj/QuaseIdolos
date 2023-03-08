@php($show = $row)

@switch(str_replace('*', '', $field))
  @case('event')
		<div class="d-flex align-items-center">
			{!! $show->status()->noText()->get() !!}
			<form method="POST" action="{{route('gig.duplicate', $show)}}">
				@csrf
				<button class="btn-raw" style="vertical-align: sub;">@fa(['icon' => 'copy', 'fa_color' => 'white'])</button>
			</form>
			<a href="{{route('shows.show', $show)}}" class="link-secondary fw-bold d-block mr-3 h5 mb-0">
				{{$show->name()}}
				@if($show->password()->required())
				<span class="ml-1 opacity-6 text-white rounded-pill bg-transparent px-2 py-1">@fa(['icon' => 'key', 'fa_size' => 'xs', 'fa_color' => 'secondary']){{$show->password}}</span>
				@endif
			</a>
		</div>
      @break

  @case('status')
	  {{$show->status()->onlyText()->get()}}
      @break

  @case('actions')
		@if($show->isLive())
		<form method="POST" action="{{route('gig.pause', $show)}}" class="d-inline mr-2">
			@csrf
			<button type="submit" class="btn btn-sm btn-secondary">
			  @fa(['icon' => $show->isPaused() ? 'play' : 'pause', 'mr' => 0])
			</button>
		</form>
		<button data-bs-toggle="modal" data-bs-target="#close-gig-{{$show->id}}-modal" class="btn btn-red btn-sm text-nowrap">Fechar</button>
		@include('pages.gigs.modals.close')
		@else
		<form method="POST" action="{{route('gig.open', $show)}}">
			@csrf
			<button class="btn btn-secondary btn-sm text-nowrap">Abrir</button>
		</form>
		@endif
      @break
@endswitch