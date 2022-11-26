@modal(['title' => 'Editar evento', 'id' => 'edit-gig-'.$gig->id.'-modal'])
<form method="POST" action="{{route('gig.update', $gig)}}">
	@csrf
	@method('PATCH')

	@input(['label' => 'Nome', 'name' => 'name', 'value' => $gig->name, 'required' => true])

	@input(['label' => 'Descrição (opcional)', 'name' => 'description', 'value' => $gig->description])

	<div class="row">
		<div class="col"> 
			@input(['label' => 'Latitude', 'name' => 'latitude', 'value' => $gig->lat])
		</div>
		<div class="col"> 
			@input(['label' => 'Longitude', 'name' => 'longitude', 'value' => $gig->lon])
		</div>
	</div>

	@input(['label' => 'Limite de repetições por música', 'placeholder' => 'Sem limite', 'name' => 'repeat_limit', 'type' => 'number', 'min' => 0, 'value' => $gig->repeat_limit])
	@input(['label' => 'Limite total de músicas', 'placeholder' => 'Sem limite', 'name' => 'songs_limit', 'type' => 'number', 'min' => 0, 'value' => $gig->songs_limit])
	@input(['label' => 'Limite de músicas por pessoa', 'placeholder' => 'Sem limite', 'name' => 'songs_limit_per_user', 'type' => 'number', 'min' => 0, 'value' => $gig->songs_limit_per_user])

	<div class="text-left mb-3"> 
		@toggle(['label' => 'Esse evento é fechado?', 'name' => 'is_private', 'on' => $gig->isPrivate()])
	</div>

	<div class="text-left mb-3"> 
		@toggle(['label' => 'Usuários podem votar?', 'name' => 'has_ratings', 'on' => $gig->participatesInRatings()])
	</div>
	
	@datepicker([
		'label' => 'Data do evento',
		'id' => uuid(),
		'value' => $gig->scheduled_for,
		'options' => ['fullwidth'],
		'name' => 'scheduled_for'])

	@submit(['label' => 'Confirmar alterações', 'theme' => 'secondary'])
</form>
@endmodal