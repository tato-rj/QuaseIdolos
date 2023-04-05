@modal(['title' => 'Editar evento', 'id' => 'edit-gig-'.$gig->id.'-modal'])
@isset($pausable)
<div class="d-flex justify-content-between align-items-end mb-3">
	<h6 class="m-0">{!! $gig->status()->get() !!}</h6>
	<form method="POST" action="{{route('gig.pause', $gig)}}">
		@csrf
		<button type="submit" class="btn btn-sm btn-secondary">
		  @fa(['icon' => $gig->isPaused() ? 'play' : 'pause', 'mr' => 0])
		</button>
	</form>
</div>
@divider
@endisset

<form method="POST" action="{{route('gig.update', $gig)}}" class="text-left">
	@csrf
	@method('PATCH')

	@unless(isset($pausable))
	<div class="text-left mb-3"> 
		@toggle(['label' => 'Evento para testes?', 'name' => 'is_test', 'on' => $gig->sandbox()])
	</div>

	@divider
	@endunless

	@isset($venues)
	@select([
		'label' => 'Contratante',
		'name' => 'venue_id'])

		@foreach($venues as $venue)
		@option(['label' => $venue->name, 'value' => $venue->id, 'name' => 'venue_id', 'selected' => $venue->id == $gig->venue_id])
		@endforeach
	@endselect
	@else
	<input type="hidden" name="venue_id" value="{{$gig->venue->id}}">
	@endisset
	
	@input(['label' => 'Nome', 'placeholder' => $gig->venue->name, 'name' => 'name', 'value' => $gig->name])
	@textarea(['label' => 'Descrição', 'placeholder' => $gig->venue->description ?? 'Sem descrição', 'name' => 'description', 'value' => $gig->description, 'rows' => 3])

	@input(['label' => 'Limite de repetições por música', 'placeholder' => 'Sem limite', 'name' => 'repeat_limit', 'type' => 'number', 'min' => 0, 'value' => $gig->repeat_limit])
	@input(['label' => 'Limite total de músicas', 'placeholder' => 'Sem limite', 'name' => 'songs_limit', 'type' => 'number', 'min' => 0, 'value' => $gig->songs_limit])
	@input(['label' => 'Limite de músicas por pessoa', 'placeholder' => 'Sem limite', 'name' => 'songs_limit_per_user', 'type' => 'number', 'min' => 0, 'value' => $gig->songs_limit_per_user])
	@input(['label' => 'Limite de músicas por set', 'placeholder' => 'Sem limite', 'name' => 'set_limit', 'type' => 'number', 'min' => 0, 'value' => $gig->set_limit])

	<div class="text-left mb-3"> 
		@toggle(['label' => 'Esse evento é fechado?', 'name' => 'is_private', 'on' => $gig->isPrivate()])
	</div>

	<div class="text-left mb-3 has-password-container"> 
		@toggle(['label' => 'Precisa de senha pra entrar?', 'name' => 'has_password', 'on' => $gig->password()->required()])
		<div
		@if(! $gig->password()->required())
		 style="display: none;"
		@endif 
		class="mt-3 custom-password">
			@input(['placeholder' => 'Senha (opcional)', 'name' => 'password', 'value' => $gig->password])
		</div>
	</div>

	<div class="text-left mb-3"> 
		@toggle(['label' => 'Usuários podem votar?', 'name' => 'has_ratings', 'on' => $gig->participatesInRatings()])
	</div>

	<div class="text-left mb-3"> 
		@toggle(['label' => 'Chat liberado?', 'name' => 'participates_in_chat', 'on' => $gig->participatesInChats()])
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
	            id="checkbox-musician-{{$musician->user->id}}-{{$gig->id}}" 
	            {{ $gig->musicians->contains($musician->user) ? ' checked' : '' }}
	            >
	                <label class="form-check-label" for="checkbox-musician-{{$musician->user->id}}-{{$gig->id}}">{{$musician->user->name}}</label>
	        </div>
	        @endforeach
		@endcheckbox
	</div>

	@datepicker([
		'label' => 'Data do evento',
		'id' => uuid(),
		'value' => $gig->isUnscheduled() ? null : $gig->scheduled_for->format('d/m/Y'),
		'options' => ['fullwidth'],
		'name' => 'scheduled_for'])

	@select([
		'label' => 'Duração do evento (opcional)',
		'placeholder' => '',
		'info' => 'Se escolhida o evento irá terminar automaticamente após o tempo escolhido.',
		'name' => 'duration'])

		@foreach(['Sem duração','1h','2h','3h','4h','5h','6h','7h','8h'] as $index => $label)
		@option(['label' => $label, 'value' => $index, 'name' => 'duration', 'selected' => $index == $gig->duration])
		@endforeach
	@endselect
	
	<div class="text-center"> 
		@submit(['label' => 'Confirmar alterações', 'theme' => 'secondary'])
	</div>
</form>
@endmodal