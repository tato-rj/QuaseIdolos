@extends('layouts.app', ['title' => 'Meu Perfil'])

@push('header')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.4.3/cropper.min.css">
<style type="text/css">
.image-container canvas { width: 100% !important; }
</style>
@endpush

@section('content')
<section class="container mb-6">
	<div class="row">
		<div class="col-lg-3 col-md-7 mx-auto col-12 text-center mb-4">
			@pagetitle(['title' => 'Meu', 'highlight' => 'perfil'])
			<div class="mb-4">

				@if($user->hasAvatar())
				@include('components.avatar.image', ['size' => '60%', 'user' => $user])
				@else
				@include('components.avatar.initial', ['size' => '140px', 'fontsize' => '3rem', 'user' => $user])
				@endif

				<h3 class="w-100 text-center mt-2"><strong>{{$user->name}}</strong></h3>
			</div>
			<div class="d-flex flex-column">
				<button data-bs-toggle="modal" data-bs-target="#edit-profile-modal" class="btn btn-secondary mb-2 text-truncate">@fa(['icon' => 'pencil-alt'])Editar Perfil</button>
				@if($user->hasOwnAvatar())
				<form method="POST" action="{{route('profile.destroy-avatar')}}">
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
		</div>
	</div>
</section>

@endsection

@push('scripts')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.4.3/cropper.min.js"></script>

<script type="text/javascript">
(new SimpleCropper({
  ratio: 1/1,
  imageInput: 'input#image-input',
  uploadButton: '#upload-button',
  confirmButton: '#confirm-button',
  cancelButton: '#cancel-button',
  submitButton: 'button[type="submit"]'
})).create();

$('label[for="upload"]').mouseover(function() {
	$(this).removeClass('opacity-8');
}).mouseleave(function() {
	$(this).addClass('opacity-8');
});

// $('input#upload').on('change', function() {
// 	let $image = $('img[name="temp-avatar"]');

// 	if (this.files && this.files[0]) {
// 		let reader = new FileReader();

//         reader.onload = function (e) {
//             $image.attr('src', e.target.result);
//         }

//         reader.readAsDataURL(this.files[0]);

//         $('#user-avatar').hide();
// 	}
// });
</script>
@endpush