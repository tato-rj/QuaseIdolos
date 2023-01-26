@auth
	@if(auth()->user()->favorited($song))
	<span class="opacity-8 small">@fa(['icon' => 'heart', 'mr' => 1])</span>
	@endif

	@if(auth()->user()->sung($song))
	<span class="opacity-8 small">@fa(['icon' => 'microphone', 'mr' => 1])</span>
	@endif
@endauth