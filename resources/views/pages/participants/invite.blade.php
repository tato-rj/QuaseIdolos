@if(auth()->user()->liveGig)
<h5 class="text-center mb-4">Convide um amigo(a) pra cantar junto!</h5>

<form method="POST"
@isset($song)
 action="{{route('song-requests.store', $song)}}"
@endisset

@isset($songRequest)
 action="{{route('song-requests.invite', $songRequest)}}"
@endisset

 data-action="sing" data-trigger="loader">
	@csrf

	<div class="mb-4 d-flex flex-wrap {{$agent->isMobile() ? 'justify-content-around' : null}}">
		@foreach(auth()->user()->liveGig->participants()->guests()->get() as $participant)
		@if(! $participant->user->is(auth()->user()))
		@isset($songRequest)
		@if(! $songRequest->invited($participant->user))
		@include('pages.participants.participant.avatar', ['selectable' => true])
		@endif
		@else
		@include('pages.participants.participant.avatar', ['selectable' => true])
		@endisset
		@endif
		@endforeach
	</div>

	@admin
	@input(['placeholder' => 'Nome do cantor', 'name' => 'user_name', 'classes' => 'btn-padding'])
	@endadmin

	<button type="submit" class="btn btn-secondary text-truncate w-100">@fa(['icon' => 'paper-plane'])ENVIAR CONVITE</button>
</form>
@endif