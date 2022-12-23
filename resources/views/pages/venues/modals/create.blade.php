@modal(['title' => 'Novo contratante', 'id' => 'create-venue-modal'])
<form method="POST" action="{{route('venues.store')}}">
	@csrf
	@input(['placeholder' => 'Nome', 'name' => 'name', 'required' => true, 'value' => old('name')])
	@textarea(['placeholder' => 'Descrição (opcional)', 'name' => 'description', 'value' => old('description'), 'rows' => 3])
	<div class="row">
		<div class="col"> 
			@input(['placeholder' => 'Latitude', 'name' => 'lat', 'value' => old('lat')])
		</div>
		<div class="col"> 
			@input(['placeholder' => 'Longitude', 'name' => 'lon', 'value' => old('lon')])
		</div>
	</div>
	@submit(['label' => 'Criar contratante', 'theme' => 'secondary'])
</form>
@endmodal