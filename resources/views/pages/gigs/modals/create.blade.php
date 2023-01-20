@modal(['title' => 'Novo evento', 'id' => 'create-gig-modal'])
<form method="POST" action="{{route('gig.store')}}">
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
	@input(['placeholder' => 'Limite de repetições por música', 'name' => 'repeat_limit', 'type' => 'number', 'min' => 0])
	@input(['placeholder' => 'Limite total de músicas', 'name' => 'songs_limit', 'type' => 'number', 'min' => 0])
	@input(['placeholder' => 'Limite de músicas por pessoa', 'name' => 'songs_limit_per_user', 'type' => 'number', 'min' => 0])
	<div class="text-left mb-3"> 
		@toggle(['label' => 'Esse evento é fechado?', 'name' => 'is_private', 'on' => old('is_private') ?? false])
	</div>
	<div class="text-left mb-3"> 
		@toggle(['label' => 'Precisa de senha pra entrar?', 'name' => 'has_password', 'on' => old('has_password') ?? false])
	</div>
	<div class="text-left mb-3"> 
		@toggle(['label' => 'Usuários podem votar?', 'name' => 'has_ratings', 'on' => old('has_ratings') ?? true])
	</div>
	
	<div class="text-left"> 
		@checkbox(['label' => 'Quem vai tocar nesse evento?', 'name' => 'musicians'])
			@foreach($musicians as $musician)
	        <div class="form-check">
	          <input 
	            class="form-check-input" 
	            name="musicians[]" 
	            type="checkbox" 
	            value="{{$musician->user->id}}" 
	            id="checkbox-musician-{{$musician->user->id}}" 
	            {{ is_array(old($name)) && in_array($value, old($name)) ? ' checked' : '' }}
	            >
	                <label class="form-check-label" for="checkbox-musician-{{$musician->user->id}}">{{$musician->user->name}}</label>
	        </div>
	        @endforeach
		@endcheckbox
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