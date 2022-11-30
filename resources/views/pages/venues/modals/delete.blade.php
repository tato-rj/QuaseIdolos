@modal(['title' => 'Tem certeza?','id' => 'delete-venue-'.$venue->id.'-modal'])
<form method="POST" action="{{route('venues.destroy', $venue)}}">
	@csrf
	@method('DELETE')

	<div class="text-left bg-white px-4 py-3 rounded mb-3">
		<p class="text-danger mb-1"><strong>@fa(['icon' => 'exclamation-circle'])Essa ação é irreversível</strong></p>
		<p class="text-dark m-0">Todas os eventos relacionados a esse contratante serão deletas também. Quer continuar?</p>
	</div>

	@submit(['label' => 'Sim, deletar contratante', 'theme' => 'secondary'])
</form>
@endmodal