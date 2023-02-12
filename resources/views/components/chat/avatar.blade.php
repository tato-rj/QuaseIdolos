<div class="text-center mb-3" style="width: 92px;">
  <div class="mb-2 position-relative">
      <div class="unread-count">
        @include('components.chat.unread', ['count' => auth()->user()->receivedMessages()->unread()->sender($user)->count()])
      </div>
      
      @if($user->hasAvatar())
      @include('components.avatar.image', ['size' => '60px'])
      @else
      @include('components.avatar.initial', ['size' => '60px'])
      @endif
  </div>
  <p class="m-0 px-2 text-truncate opacity-8">{{$user->firstName}}</p>
</div>