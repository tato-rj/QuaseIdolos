@modal(['title' => 'Editar perfil','id' => 'edit-profile-modal'])
<form method="POST" action="{{route('profile.update', $user ?? null)}}">
	@csrf
	@method('PATCH')

	@input(['placeholder' => 'Nome', 'name' => 'name', 'value' => isset($user) ? $user->name : auth()->user()->name, 'required' => true])
	@input(['placeholder' => 'Email', 'name' => 'email', 'value' => isset($user) ? $user->email : auth()->user()->email, 'required' => true])


	@submit(['label' => 'Confirmar mudanças', 'theme' => 'secondary'])
</form>
@endmodal