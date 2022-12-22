@modal(['title' => 'Editar contratante','id' => 'edit-venue-'.$venue->id.'-modal'])
<form method="POST" action="{{route('venues.update', $venue)}}" class="text-center">
	@csrf
	@method('PATCH')
	@input(['label' => 'Nome', 'name' => 'name', 'value' => $venue->name, 'required' => true])
	@textarea(['label' => 'Descrição (opcional)', 'value' => $venue->description, 'name' => 'description', 'rows' => 3])
	<div class="row">
		<div class="col"> 
			@input(['label' => 'Latitude', 'value' => $venue->lat, 'name' => 'lat'])
		</div>
		<div class="col"> 
			@input(['label' => 'Longitude', 'value' => $venue->lon, 'name' => 'lon'])
		</div>
	</div>

	@submit(['label' => 'Confirmar mudanças', 'theme' => 'secondary'])
</form>
@endmodal