@modal(['title' => 'Editar Admin', 'id' => 'edit-admin-'.$user->id.'-modal'])
<form method="POST" action="{{route('team.update', $user)}}" class="text-center">
	@csrf
	@method('PATCH')

	<div class="text-left mb-3"> 
		@toggle(['label' => 'Esse usuário é administrador?', 'name' => 'admin', 'on' => $user->isAdmin()])
	</div>

	<div class="text-left mb-4"> 
		@toggle(['label' => 'Conceder acesso total?', 'name' => 'super_admin', 'on' => $user->isSuperAdmin()])
	</div>

	@submit(['label' => 'Confirmar alterações', 'theme' => 'secondary'])
</form>
@endmodal