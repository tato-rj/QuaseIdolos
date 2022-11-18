@php($joined = auth()->user()->joined($gig))
<div class="bg-white rounded p-1 mb-3 {{$joined ? 'opacity-6' : null}}">
	<div class="rounded border border-primary border-4 p-4">
		<div class="d-apart">
			<div class="mr-3">
				<h3 class="mb-0 text-primary no-stroke text-truncate">{{$gig->name}}</h3>
			</div>
			@if($gig->isLive())
			<form method="POST" action="{{route('gig.join', $gig)}}">
				@csrf
				@method('PATCH')
				<button type="submit" {{$joined ? 'disabled' : null}} class="btn btn-secondary">
					@if($joined)
					@fa(['icon' => 'check-circle'])Estou dentro
					@else
					@fa(['icon' => 'door-open'])Entrar
					@endif
				</button>
			</form>
			@else
				<button disabled class="btn btn-secondary">@fa(['icon' => 'hourglass-half'])Ainda não começou</button>
			@endif
		</div>
		@if($gig->description)
		<p class="mb-0 mt-2 opacity-8 text-dark">{{$gig->description}}</p>
		@endif
	</div>
</div>