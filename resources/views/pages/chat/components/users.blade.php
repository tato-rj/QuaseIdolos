@unless(isset($noHeadline))
<h5 class="mb-4 text-center">Com quem quer conversar?</h5>
@endunless

<div class="d-flex flex-wrap {{$agent->isMobile() ? 'justify-content-around' : null}}">
	@foreach($users as $participant)
	@php($user = $participant->user)
	@if(! $user->is(auth()->user()))
	<div class="mb-3 {{! auth()->user()->blocked->where('user_id', $user->id)->isEmpty() ? 'opacity-4' : null}}">
		<button class="chat-user-btn btn-raw no-stroke text-white" data-url="{{route('chat.between', ['userOne' => auth()->user(), 'userTwo' => $user])}}" data-from-id="{{$user->id}}" data-target="#chat-user-{{$user->id}}">

			<div class="text-center mb-3" style="width: 92px;">
			  <div class="mb-2 position-relative">
			      <div class="unread-count-{{$user->id}}">
			        @include('pages.chat.components.unread', ['count' => auth()->user()->receivedMessages->whereNull('read_at')->where('from_id', $user->id)->count()])
			      </div>
			      
			      @if($user->hasAvatar())
			      @include('components.avatar.image', ['size' => '60px'])
			      @else
			      @include('components.avatar.initial', ['size' => '60px'])
			      @endif
			  </div>
			  <p class="m-0 px-2 text-truncate opacity-8">{{$user->firstName}}</p>
			</div>

		</button>
	</div>
	@endif
	@endforeach
</div>