	<form method="POST" action="{{route('profile.destroy-avatar', auth()->user())}}">
		@csrf
		@method('DELETE')
		<button class="btn btn-outline-secondary mb-2 text-truncate w-100">@fa(['icon' => 'camera'])Remover imagem</button>
	</form>