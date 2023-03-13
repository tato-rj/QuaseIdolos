<div class="join-card px-4 pt-4 pb-3">
	<div class="position-relative mb-4">
		<p class="mb-1">@fa(['icon' => 'check', 'fa_color' => 'green'])Você está participando do</p>
		<h3 class="no-stroke mb-4">
			{{$gig->name()}}
		</h3>
		
		@if($description = $gig->description())
		<p class="opacity-8">{{$description}}</p>
		@endif

		<form method="POST" action="{{route('gig.leave', $gig)}}" class="w-100">
			@csrf
			@method('PATCH')
			<button type="submit" class="btn btn-outline-secondary w-100">@fa(['icon' => 'sign-out-alt'])Sair</button>
		</form>
	</div>
	@divider
</div>

