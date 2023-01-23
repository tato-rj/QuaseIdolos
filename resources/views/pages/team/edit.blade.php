@modal(['title' => 'Editar Admin', 'id' => 'admin-'.$user->admin->id.'-modal'])
<form method="POST" action="{{route('team.update', $user)}}" class="text-center mb-3">
	@csrf
	@method('PATCH')

	<div class="text-left mb-3"> 
		@toggle(['label' => 'Pode controlar eventos?', 'name' => 'manage_events', 'on' => $user->admin->manage_events])
		<div class="mt-1 opacity-6 fw-bold no-stroke"><small>Permite que esse admin possa criar, editar e remover contratantes e eventos.</small></div>
	</div>

	<div class="text-left mb-3"> 
		@toggle(['label' => 'Pode controlar o setlist?', 'name' => 'manage_setlist', 'on' => $user->admin->manage_setlist])
		<div class="mt-1 opacity-6 fw-bold no-stroke"><small>Permite que esse admin mudar a ordem das músicas no setlist, bem como confirmar ou cancelar qualquer pedido.</small></div>
	</div>

	<div class="text-left mb-4"> 
		@checkbox(['label' => 'Quais instrumentos?', 'name' => 'instruments'])
			@foreach(['guitarra', 'baixo', 'voz', 'bateria', 'teclado'] as $instrument)
	        <div class="form-check">
	          <input 
	            class="form-check-input" 
	            name="instruments[]" 
	            type="checkbox" 
	            value="{{$instrument}}" 
	            id="checkbox-instrument-{{$instrument}}-{{$user->admin->id}}" 
	            {{ in_array($instrument, $user->admin->instruments) ? ' checked' : '' }}
	            >
	                <label class="form-check-label" for="checkbox-instrument-{{$instrument}}-{{$user->admin->id}}">{{ucfirst($instrument)}}</label>
	        </div>
	        @endforeach
		@endcheckbox
	</div>

	@submit(['label' => 'Confirmar alterações', 'theme' => 'secondary'])
</form>

<form method="POST" action="{{route('team.revoke', $user)}}" class="text-center">
	@csrf
	@method('DELETE')

	@submit(['label' => 'Remover admin status', 'theme' => 'outline-secondary'])
</form>
@endmodal