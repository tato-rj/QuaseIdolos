@modal(['title' => 'Novo show', 'id' => 'edit-show-'.$show->id.'-modal'])
<form method="POST" action="{{route('shows.update', $show)}}">
	@csrf
	@method('PATCH')

	@isset($venue)
	<input type="hidden" name="venue_id" value="{{$venue->id}}">
	@else
	@select([
		'placeholder' => 'Contratante',
		'name' => 'venue_id'])
		@foreach($venues as $venue)
		@option(['label' => $venue->name, 'value' => $venue->id, 'name' => 'venue_id', 'selected' => $venue->id == $show->venue_id])
		@endforeach
	@endselect
	@endisset

	@input(['label' => 'Nome', 'placeholder' => $show->venue->name, 'name' => 'name', 'value' => $show->name])
	@textarea(['label' => 'Descrição', 'placeholder' => $show->venue->description ?? 'Sem descrição', 'name' => 'description', 'value' => $show->description, 'rows' => 3])
	
	<div class="text-left"> 
		@checkbox(['label' => 'Quem vai tocar nesse show?', 'name' => 'musicians'])
			@foreach($musicians as $musician)
			@php($checkID = uuid())
	        <div class="form-check">
	          <input 
	            class="form-check-input" 
	            name="musicians[]" 
	            type="checkbox" 
	            value="{{$musician->user->id}}" 
	            id="checkbox-musician-{{$checkID}}" 
	            {{ $show->musicians->contains($musician->user) ? ' checked' : '' }}
	            >
	                <label class="form-check-label" for="checkbox-musician-{{$checkID}}">{{$musician->user->name}}</label>
	        </div>
	        @endforeach
		@endcheckbox
	</div>

	@datepicker([
		'label' => 'Data do show',
		'value' => $show->isUnscheduled() ? null : $show->scheduled_for->format('d/m/Y'),
		'id' => uuid(),
		'options' => ['fullwidth'],
		'name' => 'scheduled_for'])

	@select([
		'placeholder' => 'Duração do show (opcional)',
		'info' => 'Se escolhida o show irá terminar automaticamente após o tempo escolhido.',
		'name' => 'duration'])

		@foreach(['Sem duração','1h','2h','3h','4h','5h','6h','7h','8h'] as $index => $label)
		@option(['label' => $label, 'value' => $index, 'name' => 'duration', 'selected' => $index == $show->duration])
		@endforeach
	@endselect


	@submit(['label' => 'Confirmar alterações', 'theme' => 'secondary'])

</form>
@endmodal