@extends('layouts.app', ['title' => $user->name])

@push('header')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.4.3/cropper.min.css">
<style type="text/css">
.image-container canvas { width: 100% !important; }

.song-result:nth-child(n+6) {
	display: none;
}
</style>
@endpush

@section('content')
<section class="container py-4">
		@if($user->banned())
		<div class="mx-auto mb-4" style="width: 100%; max-width: 600px"> 
		@alert([
	    'color' => 'red',
	    'headline' => __('views/alert.error'),
	    'message' => 'Este usuário está banido',
	    'dismissible' => true])
	  </div>
	  @endif

		@if(! $user->email && auth()->user()->is($user))
		<div class="mx-auto mb-4" style="width: 100%; max-width: 600px"> 
		@alert([
	    'color' => 'red',
	    'headline' => __('views/alert.error'),
	    'message' => __('views/user.missing-email'),
	    'dismissible' => true])
	  </div>
	  @endif
	<div class="row">
		<div class="col-lg-3 col-md-7 mx-auto col-12 text-center mb-4">
			<div class="mb-3">
				@include('pages.users.avatar', ['size' => '180px', 'namesize' => '2rem'])
			</div>

			<div class="d-flex flex-column">
				@if($user->banned())
				@form(['method' => 'POST', 'classes' => 'mb-2', 'url' => route('users.unban', $user)])
				<button type="subtmie" class="btn btn-outline-secondary w-100">Reativar conta</button>
				@endform
				@endif

				@if($user->socialAccounts()->exists())
					@include('pages.users.actions.social')
				@endif

				@if($user->hasOwnAvatar())
					@include('pages.users.actions.avatar')
				@endif

				@if($user->socialAccounts()->exists() || $user->hasOwnAvatar())
				@include('layouts.menu.components.divider')
				@endif

				@include('pages.users.actions.edit')
				
				@include('pages.users.actions.password')
				
				@include('pages.users.actions.delete')

				<div class="d-center my-2">
					@foreach(['facebook', 'google', 'instagram'] as $provider)
					@fa(['icon' => $provider, 'fa_size' => '2x', 'fa_type' => 'b', 'mr' => 0, 'classes' => $user->socialAccounts()->provider($provider)->exists() ? 'mx-2 opacity-8' : 'mx-2 opacity-2'])
					@endforeach
				</div>
				<small class="opacity-6">@lang('views/user.created_at') {{$user->created_at->format('d/m/Y')}}</small>
			</div>
		</div>

		<div class="col-lg-9 col-12">
			@table([
				'title' => __('views/user.tables.gig'),
				'empty' => true,
				'columns' => ['scheduled_for' => 'Data', 'name' => 'Evento'],
				'legend' => 'evento|eventos',
				'rows' => $user->participations()->confirmed()->paginate(8),
				'view' => 'pages.users.rows.gigs'
			])
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
</script>
@endpush