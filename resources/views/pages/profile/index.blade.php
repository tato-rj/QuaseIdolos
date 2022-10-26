@extends('layouts.app', ['title' => 'Meu Perfil'])

@push('header')
<style type="text/css">

</style>
@endpush

@section('content')
<section class="container py-4">
	<div class="row">
		<div class="col-lg-3 col-md-7 mx-auto col-12 text-center mb-4">
			<h2 class="mb-3">MEU <span class="text-secondary">PERFIL</span></h2>
			<div class="mb-3">

				@if(auth()->user()->hasAvatar())
				@include('components.avatar.image', ['size' => '60%', 'user' => auth()->user()])
				@else
				@include('components.avatar.initial', ['size' => '140px', 'fontsize' => '3rem', 'user' => auth()->user()])
				@endif

				<p class="w-100 text-center mt-2 text-truncate" style="font-size: 1.6rem;"><strong>{{auth()->user()->name}}</strong></p>
			</div>
			<div class="d-flex flex-column">
				<button data-bs-toggle="modal" data-bs-target="#edit-profile-modal" class="btn btn-secondary mb-2 text-truncate">@fa(['icon' => 'pencil-alt'])Editar Perfil</button>
				<button data-bs-toggle="modal" data-bs-target="#edit-password-modal" class="btn btn-secondary mb-2 text-truncate">@fa(['icon' => 'lock'])Mudar Senha</button>
				<button data-bs-toggle="modal" data-bs-target="#delete-user-modal" class="btn btn-outline-secondary text-truncate">@fa(['icon' => 'trash-alt'])Deletar conta</button>

				@include('pages.profile.modals.profile')
				@include('pages.profile.modals.password')
				@include('pages.profile.modals.delete')
			</div>
		</div>
	</div>
</section>

@endsection

@push('scripts')
@endpush