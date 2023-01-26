<div class="d-flex mt-2">
	@foreach($entry->guests as $guest)
		<div class="position-relative" 
			@if(!$loop->first)
			style="margin-left: -8px; z-index: {{$loop->iteration}}"
			@endif
		>
	      @if($guest->user->hasAvatar())
	      @include('components.avatar.image', ['size' => '36px', 'user' => $guest->user])
	      @else
	      @include('components.avatar.initial', ['size' => '36px', 'user' => $guest->user])
	      @endif
	  </div>
	@endforeach
</div>