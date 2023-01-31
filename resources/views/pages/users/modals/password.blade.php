@modal(['title' => 'Mudar senha','id' => 'edit-password-modal'])
<form method="POST" action="{{route('profile.password', $user ?? null)}}">
	@csrf

	<div class="text-left"> 
	@password([
		'label' => 'Senha antiga',
		'name' => 'old_password', 
		'placeholder' => '******'])

	@password([
		'label' => 'Nova senha',
		'name' => 'new_password', 
		'placeholder' => '******'])

	@password([
		'label' => 'Confirma a sua nova senha',
		'name' => 'new_password_confirmation', 
		'placeholder' => '******'])
	</div>


	@submit(['label' => 'Confirmar nova senha', 'theme' => 'secondary'])
</form>
@endmodal