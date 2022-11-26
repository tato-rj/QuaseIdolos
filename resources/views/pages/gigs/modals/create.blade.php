@modal(['title' => 'Novo evento', 'id' => 'create-gig-modal'])
<form method="POST" action="{{route('gig.store')}}">
	@csrf
	@input(['placeholder' => 'Nome', 'name' => 'name', 'required' => true])
	@input(['placeholder' => 'Descrição (opcional)', 'name' => 'description'])

	<div class="row">
		<div class="col"> 
			@input(['placeholder' => 'Latitude', 'name' => 'latitude'])
		</div>
		<div class="col"> 
			@input(['placeholder' => 'Longitude', 'name' => 'longitude'])
		</div>
	</div>

	@input(['placeholder' => 'Limite de repetições por música', 'name' => 'repeat_limit', 'type' => 'number', 'min' => 0])
	@input(['placeholder' => 'Limite total de músicas', 'name' => 'songs_limit', 'type' => 'number', 'min' => 0])
	@input(['placeholder' => 'Limite de músicas por pessoa', 'name' => 'songs_limit_per_user', 'type' => 'number', 'min' => 0])
	<div class="text-left mb-3"> 
		@toggle(['label' => 'Esse evento é fechado?', 'name' => 'is_private', 'on' => old('is_private') ?? false])
	</div>
	<div class="text-left mb-3"> 
		@toggle(['label' => 'Usuários podem votar?', 'name' => 'has_ratings', 'on' => old('has_ratings') ?? true])
	</div>
	@datepicker([
		'label' => 'Data do evento',
		'value' => now()->format('d/m/Y'),
		'id' => uuid(),
		'options' => ['fullwidth'],
		'name' => 'scheduled_for'])
	@submit(['label' => 'Criar evento', 'theme' => 'secondary'])
</form>
@endmodal