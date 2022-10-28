@modal(['title' => 'Editar evento', 'id' => 'edit-gig-'.$gig->id.'-modal'])
<form method="POST" action="{{route('gig.update', $gig)}}">
	@csrf
	@method('PATCH')
	@input(['placeholder' => 'Nome', 'name' => 'name', 'value' => $gig->name, 'required' => true])
	@input(['placeholder' => 'Descrição (opcional)', 'name' => 'description', 'value' => $gig->description])

	@input(['placeholder' => 'Limite total de músicas', 'name' => 'songs_limit', 'type' => 'number', 'min' => 1, 'value' => $gig->songs_limit])
	@input(['placeholder' => 'Limite de músicas por pessoa', 'name' => 'songs_limit_per_user', 'type' => 'number', 'min' => 1, 'value' => $gig->songs_limit_per_user])

	@datepicker([
		'label' => 'Data do evento',
		'id' => uuid(),
		'value' => $gig->date,
		'options' => ['fullwidth'],
		'name' => 'date'])
	@submit(['label' => 'Confirmar alterações', 'theme' => 'secondary'])
</form>
@endmodal