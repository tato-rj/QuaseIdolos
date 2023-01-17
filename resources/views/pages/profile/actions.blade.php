<div class="d-flex flex-column">

	@if($user->hasOwnLogin())
	@foreach($user->socialAccounts as $socialAccount)
	<form method="POST" action="{{route('profile.unlink-social', $socialAccount)}}">
		@csrf
		@method('DELETE')
		<button type="submit" class="btn btn-{{$socialAccount->social_provider}} w-100 mb-2">@fa(['icon' => $socialAccount->social_provider, 'fa_type' => 'b'])Remover {{ucfirst($socialAccount->social_provider)}}</button>
	</form>
	@endforeach
	@endif

	<button data-bs-toggle="modal" data-bs-target="#edit-profile-modal" class="btn btn-secondary mb-2 text-truncate">@fa(['icon' => 'pencil-alt'])Editar Perfil</button>
	@if($user->hasOwnAvatar())
	<form method="POST" action="{{route('profile.destroy-avatar', auth()->user())}}">
		@csrf
		@method('DELETE')
		<button class="btn btn-secondary mb-2 text-truncate w-100">@fa(['icon' => 'camera'])Remover imagem</button>
	</form>
	@endif
	<button data-bs-toggle="modal" data-bs-target="#edit-password-modal" class="btn btn-secondary mb-2 text-truncate">@fa(['icon' => 'lock'])Mudar Senha</button>
	<button data-bs-toggle="modal" data-bs-target="#delete-user-modal" class="btn btn-outline-secondary text-truncate mb-2">@fa(['icon' => 'trash-alt'])Deletar conta</button>
	<small class="opacity-6">Cadastro feito em {{$user->created_at->format('d/m/Y')}}</small>
	
	@include('pages.profile.modals.profile')
	@include('pages.profile.modals.password')
	@include('pages.profile.modals.delete')
</div>