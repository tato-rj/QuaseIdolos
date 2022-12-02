@modal(['title' => 'Editar evento', 'id' => 'edit-gig-'.$gig->id.'-modal'])
<form method="POST" action="{{route('gig.update', $gig)}}" class="text-left">
	@csrf
	@method('PATCH')

	@isset($venues)
	@select([
		'label' => 'Contratante',
		'name' => 'venue_id'])

		@foreach($venues as $venue)
		@option(['label' => $venue->name, 'value' => $venue->id, 'name' => 'venue_id', 'selected' => $venue->id == $gig->venue_id])
		@endforeach
	@endselect
	@endisset
	
	@input(['label' => 'Nome', 'placeholder' => $gig->venue->name, 'name' => 'name', 'value' => $gig->name])
	@input(['label' => 'Descrição', 'placeholder' => $gig->venue->description, 'name' => 'description', 'value' => $gig->description])

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
		'value' => $gig->hasDate() ? $gig->dateForHumans : null,
		'options' => ['fullwidth'],
		'name' => 'scheduled_for'])

		<div class="text-center"> 
			@submit(['label' => 'Confirmar alterações', 'theme' => 'secondary'])
		</div>
</form>
@endmodal