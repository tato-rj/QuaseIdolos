@foreach($entry->singers() as $user)
	<div class="position-relative" style="margin-left: {{! $loop->first ? '-16px' : null}}; z-index: {{$loop->remaining}};">
      @if($user->hasAvatar())
      @include('components.avatar.image', ['size' => '56px', 'classes' => ! $user->confirmed_at ? 'opacity-4 grayscale' : 'border border-2'])
      @else
      @include('components.avatar.initial', ['size' => '56px', 'classes' => ! $user->confirmed_at ? 'opacity-4 grayscale' : 'border border-2'])
      @endif
  </div>
@endforeach