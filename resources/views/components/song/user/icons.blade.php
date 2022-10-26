@auth
	@if(auth()->user()->favorited($song)->exists())
	<span class="opacity-8 small">@fa(['icon' => 'heart', 'mr' => 1])</span>
	@endif
	@if(auth()->user()->completed($song)->exists())
	<span class="opacity-8 small">@fa(['icon' => 'microphone', 'mr' => 1])</span>
	@endif
@endauth