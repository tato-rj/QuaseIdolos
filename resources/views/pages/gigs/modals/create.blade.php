@modal(['title' => 'Novo evento', 'id' => 'create-gig-modal'])
<form method="POST" action="{{route('gig.store')}}">
	@csrf
	
	<div class="text-left mb-3"> 
		@toggle(['label' => 'Evento para testes?', 'name' => 'is_test', 'on' => old('is_test') ?? false])
	</div>
	
	@divider

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
		@toggle(['label' => 'Esse evento é um show solo da banda?', 'name' => 'is_show', 'on' => old('is_show') ?? false])
	</div>
	<div class="text-left mb-3"> 
		@toggle(['label' => 'Esse evento é fechado?', 'name' => 'is_private', 'on' => old('is_private') ?? false])
	</div>
	<div class="text-left mb-3 has-password-container"> 
		@toggle(['label' => 'Precisa de senha pra entrar?', 'name' => 'has_password', 'on' => old('has_password') ?? false])
		<div 
		@if(! old('has_password'))
		style="display: none;"
		@endif
		class="mt-3 custom-password">
			@input(['placeholder' => 'Senha (opcional)', 'name' => 'password', 'value' => old('password')])
		</div>
	</div>
	<div class="text-left mb-3"> 
		@toggle(['label' => 'Usuários podem votar?', 'name' => 'has_ratings', 'on' => old('has_ratings') ?? true])
	</div>

	<div class="text-left mb-3"> 
		@toggle(['label' => 'Chat liberado?', 'name' => 'participates_in_chat', 'on' => old('participates_in_chat') ?? true])
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
	            {{ is_array(old('musicians')) && in_array($musician->user->id, old('musicians')) ? ' checked' : '' }}
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
		'placeholder' => 'Duração do evento (opcional)',
		'info' => 'Se escolhida o evento irá terminar automaticamente após o tempo escolhido.',
		'name' => 'duration'])

		@foreach([1,2,3,4,5,6,7,8] as $duration)
		@option(['label' => $duration . 'h', 'value' => $duration, 'name' => 'duration', 'selected' => $duration == old('duration')])
		@endforeach
	@endselect


	@submit(['label' => 'Criar evento', 'theme' => 'secondary'])

</form>
@endmodal