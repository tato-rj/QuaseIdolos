@modal(['title' => 'Novo evento', 'id' => 'create-gig-modal'])
<form method="POST" action="{{route('gig.store')}}">
	@csrf
	@select([
		'placeholder' => 'Contratante',
		'name' => 'venue_id'])

		@foreach($venues as $venue)
		@option(['label' => $venue->name, 'value' => $venue->id, 'name' => 'venue_id', 'selected' => $venue->id == old('venue_id')])
		@endforeach
	@endselect

	@input(['placeholder' => 'Nome (opcional)', 'name' => 'name'])
	@input(['placeholder' => 'Descrição (opcional)', 'name' => 'description'])
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

	@select([
		'placeholder' => 'Hora do evento (opcional)',
		'name' => 'starting_time'])

		@foreach(timeslots(16, 24) as $date => $time)
		@option(['label' => $time, 'value' => $time, 'name' => 'starting_time', 'selected' => $time == old('starting_time')])
		@endforeach
	@endselect
	
	@submit(['label' => 'Criar evento', 'theme' => 'secondary'])
</form>
@endmodal