@modal(['title' => 'Editar perfil','id' => 'edit-profile-modal'])
<form method="POST" action="{{route('profile.update', $user ?? null)}}" enctype="multipart/form-data">
	@csrf
	@method('PATCH')

	@php($user = $user ?? auth()->user())

	<div class="mx-auto mb-4" style="width: 300px">
		@include('pages.profile.avatar')
	</div>

	@input(['placeholder' => 'Nome', 'name' => 'name', 'value' => $user->name, 'required' => true])
	@input(['placeholder' => 'Email', 'name' => 'email', 'value' => $user->email])

	<div class="text-left mb-3"> 
		@toggle(['label' => 'Participar das votações?', 'name' => 'has_ratings', 'on' => $user->participatesInRatings()])
	</div>
	@submit(['label' => 'Confirmar mudanças', 'theme' => 'secondary'])
</form>
@endmodal