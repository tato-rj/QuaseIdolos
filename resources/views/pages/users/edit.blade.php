@extends('layouts.app', ['title' => $user->name])

@push('header')
<style type="text/css">
.song-result:nth-child(n+6) {
	display: none;
}
</style>
@endpush

@section('content')
<section class="container py-4">
	<div class="row">
		<div class="col-lg-3 col-md-7 mx-auto col-12 text-center mb-4">
			<div class="mb-3">
				@include('pages.users.avatar', ['size' => '180px', 'fontsize' => '3rem', 'namesize' => '1.6rem'])
			</div>
			<div class="d-flex flex-column">
				<button data-bs-toggle="modal" data-bs-target="#edit-profile-modal" class="btn btn-secondary mb-2 text-truncate">@fa(['icon' => 'pencil-alt'])Editar Perfil</button>
				<button data-bs-toggle="modal" data-bs-target="#edit-password-modal" class="btn btn-secondary mb-2 text-truncate">@fa(['icon' => 'lock'])Mudar Senha</button>
				<button data-bs-toggle="modal" data-bs-target="#delete-user-modal" class="btn btn-outline-secondary mb-2 text-truncate">@fa(['icon' => 'trash-alt'])Deletar conta</button>
				@admin
				<small class="opacity-6">Último login {{$user->updated_at->diffForHumans()}}</small>
				@endadmin

				<div class="d-center mt-4">
					@fa(['icon' => 'facebook', 'fa_size' => '2x', 'fa_type' => 'b', 'mr' => 0, 'classes' => 'mx-2 opacity-2'])
					@fa(['icon' => 'instagram', 'fa_size' => '2x', 'fa_type' => 'b', 'mr' => 0, 'classes' => 'mx-2 opacity-2'])
					@fa(['icon' => 'google', 'fa_size' => '2x', 'fa_type' => 'b', 'mr' => 0, 'classes' => 'mx-2 opacity-2'])
					@fa(['icon' => 'github', 'fa_size' => '2x', 'fa_type' => 'b', 'mr' => 0, 'classes' => 'mx-2 opacity-2'])
				</div>

				@include('pages.profile.modals.profile', ['user' => $user])
				@include('pages.profile.modals.password', ['user' => $user])
				@include('pages.profile.modals.delete', ['user' => $user])
			</div>
		</div>

		<div class="col-lg-9 col-12">
			<div class="mb-5">
				<h5 class="mb-3">Total de {{$favorites->count()}} @choice('favorito|favoritos', $favorites->count())</h5>
				@foreach($favorites as $song)
					@include('pages.users.rows.favorite')
					@if($loop->iteration == 4 && $loop->remaining)
					@include('components.tables.rows.more')
					@endif
				@endforeach
			</div>
			<div>
				<h5 class="mb-3">Total de {{$pastList->count()}} @choice('música|músicas', $pastList->count()) @choice('cantada|cantadas', $pastList->count())</h5>
				@foreach($pastList as $list)
					@include('pages.users.rows.setlist')
					@if($loop->iteration == 4 && $loop->remaining)
					@include('components.tables.rows.more')
					@endif
				@endforeach
			</div>
		</div>
	</div>
</section>


@endsection

@push('scripts')
@endpush