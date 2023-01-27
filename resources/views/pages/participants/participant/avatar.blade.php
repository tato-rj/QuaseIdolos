<div class="text-center mb-3 cursor-pointer"
@isset($selectable)
name="participant-avatar"
data-id="{{$participant->user->id}}"
@else
data-bs-toggle="modal" data-bs-target="#participant-{{$participant->id}}-modal"
@endisset

 style="width: 92px;">
	<div class="mb-2 position-relative">
        <div class="position-absolute-center opacity-6 checkmark" style="z-index: 1; display: none">@fa(['icon' => 'check-circle', 'mr' => 0, 'fa_size' => '2x', 'fa_color' => 'green'])</div>
      @if($participant->user->hasAvatar())
      @include('components.avatar.image', ['size' => '60px', 'user' => $participant->user])
      @else
      @include('components.avatar.initial', ['size' => '60px', 'user' => $participant->user])
      @endif
	</div>
	<p class="m-0 px-2 text-truncate opacity-8">{{$participant->user->firstName}}</p>

    @isset($selectable)
          <input name="participants[]" style="opacity:0; position:absolute; left:9999px;" type="checkbox" 
            value="{{$participant->user->id}}">
    @endisset
</div>
