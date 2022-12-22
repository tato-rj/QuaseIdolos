@php($joined = auth()->user()->joined($gig))
@php($live = $gig->isLive())
@php($over = $gig->isOver())

<div class="bg-white rounded p-1 {{$loop->last ? null : 'mb-3'}} {{$joined || !$live ? 'opacity-6' : null}}">
	<div class="rounded border border-primary border-4 p-4 position-relative {{$live ? 'text-primary' : 'text-muted'}}">
		@if($joined)
		<div class="position-absolute-center opacity-6 text-green">@fa(['icon' => 'check-circle', 'mr' => 0, 'fa_size' => '4x'])</div>
		@endif

		<div class="d-apart">
			<div class="mr-3">
				<h3 class="mb-0 no-stroke text-truncate">{{$gig->name()}}</h3>
			</div>
			@if($live && ! $joined)
			<form method="POST" action="{{route('gig.join', $gig)}}">
				@csrf
				@method('PATCH')
				<button type="submit" {{$joined ? 'disabled' : null}} class="btn btn-secondary">@fa(['icon' => 'door-open'])Entrar</button>
			</form>
			@endif
		</div>
		@if($description = $gig->description())
		<p class="mb-0 mt-2 opacity-8">{{$description}}</p>
		@endif

		@if($live)
		<h6 class="border border-primary no-stroke rounded-pill w-100 mt-3 text-center p-1 mb-0">
			@if($joined)
			Estou no {{$gig->name()}}
			@else
			Abriu {{$gig->starts_at->diffForHumans()}}
			@endif
		</h6>
		@elseif($over)
		<h6 class="border border-muted no-stroke rounded-pill w-100 mt-3 text-center p-1 mb-0">{{$gig->status()->onlyText()->get()}}</h6>
		@endif
	</div>
</div>