<h5 class="mb-4 text-center">Com quem quer conversar?</h5>

<div class="d-flex flex-wrap {{$agent->isMobile() ? 'justify-content-around' : null}}">
	@foreach($participants as $participant)
	@php($user = $participant->user)
	@if(! $user->is(auth()->user()))
	<div class="mb-3">
		<button class="btn-raw no-stroke text-white" data-url="{{route('chat.between', ['userOne' => auth()->user(), 'userTwo' => $user])}}" data-from-id="{{$user->id}}" data-target="#chat-user-{{$user->id}}">
			@include('components.chat.avatar')
		</button>
	</div>
	@endif
	@endforeach
</div>