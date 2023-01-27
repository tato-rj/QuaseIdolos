<div class="mb-3">
	<div class="opacity-6 fw-bold mb-2">Quem convidou?</div>
	<div class="d-flex align-items-center">
		<div class="mr-2 no-truncate">
			@if($user->hasAvatar())
			@include('components.avatar.image', ['size' => '40px'])
			@else
			@include('components.avatar.initial', ['size' => '40px'])
			@endif
		</div>
    	<h4 class="mr-2 mb-0 align-middle">{{$user->name}}</h4>
	</div>
</div>

<div class="mb-4">
	<div class="opacity-6 fw-bold mb-1">Pra cantar qual música?</div>
	<div>
		<h4 class="m-0" style="white-space: initial;">{{$song->name}}</h4>
		<h6 class="m-0 text-truncate text-secondary">{{$song->artist->name}}</h6>
	</div>
</div>

@form(['method' => 'PATCH', 'url' => route('song-requests.confirm-invitation', $invitation->songRequest), 'data' => ['trigger' => 'loader']])
<button type="submit" class="btn btn-secondary w-100 mb-2">Sim, vamos cantar!</button>
@endform

@form(['method' => 'DELETE', 'url' => route('song-requests.decline', $invitation->songRequest), 'data' => ['trigger' => 'loader']])
<button type="submit" class="btn btn-outline-secondary w-100">Não quero cantar essa</button>
@endform
