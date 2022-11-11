@modal(['title' => 'Novo evento', 'id' => 'create-gig-modal'])
<form method="POST" action="{{route('gig.store')}}">
	@csrf
	@input(['placeholder' => 'Nome', 'name' => 'name', 'required' => true])
	@input(['placeholder' => 'Descrição (opcional)', 'name' => 'description'])

	@input(['placeholder' => 'Limite total de músicas', 'name' => 'songs_limit', 'type' => 'number', 'min' => 1])
	@input(['placeholder' => 'Limite de músicas por pessoa', 'name' => 'songs_limit_per_user', 'type' => 'number', 'min' => 1])
	<div class="text-left mb-3"> 
		@toggle(['label' => 'Usuários podem votar?', 'name' => 'has_ratings', 'on' => old('has_ratings')])
	</div>
	@datepicker([
		'label' => 'Data do evento',
		'id' => uuid(),
		'options' => ['fullwidth'],
		'name' => 'date'])
	@submit(['label' => 'Criar evento', 'theme' => 'secondary'])
</form>
@endmodal