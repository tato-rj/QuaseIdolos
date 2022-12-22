<div class="join-content">
	@if($joined)
	<div class="position-absolute-center opacity-6 text-green">@fa(['icon' => 'check-circle', 'mr' => 0, 'fa_size' => '4x'])</div>
	@endif

	<div class="d-apart">
		<div class="mr-3">
			<h3 class="mb-0 no-stroke text-truncate">{{$gig->name()}}</h3>
		</div>
		@if($live && ! $joined)
			@if($gig->password()->required())
			<button name="show_password_container" data-target="#gig-{{$gig->id}}-password-container" class="btn btn-secondary">@fa(['icon' => 'door-open'])Entrar</button>
			@else
			<form method="POST" action="{{route('gig.join', $gig)}}">
				@csrf
				@method('PATCH')
				<button type="submit" {{$joined ? 'disabled' : null}} class="btn btn-secondary">@fa(['icon' => 'door-open'])Entrar</button>
			</form>
			@endif
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
	@else
	<h6 class="border border-muted no-stroke rounded-pill w-100 mt-3 text-center p-1 mb-0">{{$gig->status()->onlyText()->get()}}</h6>
	@endif
</div>