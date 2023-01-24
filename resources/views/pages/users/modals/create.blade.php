@modal(['title' => 'Novo usuário', 'id' => 'create-user-modal'])
<form method="POST" action="{{route('users.store')}}">
	@csrf
	@input([
		'icon' => 'user',
		'label' => 'Nome',
		'required' => true,
		'name' => 'name', 
		'placeholder' => 'Maria dos Santos'])

	@input([
		'icon' => 'envelope',
		'label' => 'Email',
		'required' => true,
		'name' => 'email', 
		'type' => 'email', 
		'placeholder' => 'meu@email.com'])

	@password([
		'label' => 'Senha',
		'required' => true,
		'name' => 'password', 
		'placeholder' => '******'])

	@password([
		'label' => 'Confirma a senha',
		'name' => 'password_confirmation', 
		'required' => true,
		'placeholder' => '******'])

	@submit(['label' => 'Criar usuário', 'theme' => 'secondary'])
</form>
@endmodal