@modal(['title' => 'Novo show', 'id' => 'create-show-modal'])
<form method="POST" action="{{route('shows.store')}}">
	@csrf

	@isset($venue)
	<input type="hidden" name="venue_id" value="{{$venue->id}}">
	@else
	@select([
		'placeholder' => 'Contratante',
		'name' => 'venue_id'])
		@foreach($venues as $venue)
		@option(['label' => $venue->name, 'value' => $venue->id, 'name' => 'venue_id', 'selected' => $venue->id == old('venue_id')])
		@endforeach
	@endselect
	@endisset

	@input(['placeholder' => 'Nome (opcional)', 'name' => 'name', 'value' => old('name')])
	@textarea(['placeholder' => 'Descrição (opcional)', 'name' => 'description', 'value' => old('description'), 'rows' => 3])
	
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
	            {{ is_array(old('musicians')) && in_array($musician->user->id, old('musicians')) ? ' checked' : '' }}
	            >
	                <label class="form-check-label" for="checkbox-musician-{{$checkID}}">{{$musician->user->name}}</label>
	        </div>
	        @endforeach
		@endcheckbox
	</div>

	@datepicker([
		'label' => 'Data do show',
		'value' => now()->format('d/m/Y'),
		'id' => uuid(),
		'options' => ['fullwidth'],
		'name' => 'scheduled_for'])

	@select([
		'placeholder' => 'Duração do show (opcional)',
		'info' => 'Se escolhida o show irá terminar automaticamente após o tempo escolhido.',
		'name' => 'duration'])

		@foreach([1,2,3,4,5,6,7,8] as $duration)
		@option(['label' => $duration . 'h', 'value' => $duration, 'name' => 'duration', 'selected' => $duration == old('duration')])
		@endforeach
	@endselect


	@submit(['label' => 'Criar show', 'theme' => 'secondary'])

</form>
@endmodal