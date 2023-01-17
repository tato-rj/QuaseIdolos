@php($user = $user ?? auth()->user())

@extends('layouts.app', ['title' => 'Meu Perfil'])

@push('header')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.4.3/cropper.min.css">
<style type="text/css">
.image-container canvas { width: 100% !important; }
</style>
@endpush

@section('content')
<section class="container mb-6">
		@if(! $user->email)
		<div class="mx-auto mb-4" style="width: 100%; max-width: 600px"> 
		@alert([
	    'color' => 'red',
	    'headline' => 'Atenção',
	    'message' => 'Não temos o seu email cadastrado.',
	    'dismissible' => true])
	  </div>
	  @endif
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

			@include('pages.profile.actions')
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