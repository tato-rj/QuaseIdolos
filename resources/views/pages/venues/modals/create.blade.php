@modal(['title' => 'Novo contratante', 'id' => 'create-venue-modal'])
<form method="POST" action="{{route('venues.store')}}">
	@csrf
	@input(['placeholder' => 'Nome', 'name' => 'name', 'required' => true])
	@textarea(['placeholder' => 'Descrição (opcional)', 'name' => 'description'])
	<div class="row">
		<div class="col"> 
			@input(['placeholder' => 'Latitude', 'name' => 'lat'])
		</div>
		<div class="col"> 
			@input(['placeholder' => 'Longitude', 'name' => 'lon'])
		</div>
	</div>
	@submit(['label' => 'Adicionar contratante', 'theme' => 'secondary'])
</form>
@endmodal