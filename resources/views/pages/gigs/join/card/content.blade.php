<div class="join-content">
	@if($joined)
	<div class="position-absolute-center opacity-6 text-green">@fa(['icon' => 'check-circle', 'mr' => 0, 'fa_size' => '4x'])</div>
	@endif

	<h3 class="no-stroke">{{$gig->name()}}</h3>

	@if($description = $gig->description())
	<p class="opacity-8">{{$description}}</p>
	@endif

	@if($live && ! $joined)
		@if($gig->password()->required())
		<button name="show_password_container" data-target="#gig-{{$gig->id}}-password-container" class="btn btn-secondary w-100">@fa(['icon' => 'door-open'])Entrar</button>
		@else
		<form method="POST" action="{{route('gig.join', $gig)}}" class="w-100">
			@csrf
			@method('PATCH')
			<button type="submit" {{$joined ? 'disabled' : null}} class="btn btn-secondary w-100">@fa(['icon' => 'door-open'])Entrar</button>
		</form>
		@endif
	@endif

	@if(! $live)

	<h6 class="border border-muted no-stroke rounded-pill w-100 mt-3 text-center p-1 mb-0">{{$gig->status()->onlyText()->get()}}</h6>
	@endif
</div>