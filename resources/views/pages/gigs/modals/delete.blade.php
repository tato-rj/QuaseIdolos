@modal(['title' => 'Tem certeza?','id' => 'delete-gig-'.$gig->id.'-modal'])
<form method="POST" action="{{route('gig.destroy', $gig)}}" class="text-center">
	@csrf
	@method('DELETE')

	<div class="text-left bg-white px-4 py-3 rounded mb-3">
		<p class="text-danger mb-1"><strong>@fa(['icon' => 'exclamation-circle'])Essa ação é irreversível</strong></p>
		<p class="text-dark m-0">O setlist desse evento <u>não</u> será removido, esses registros vão ficar sempre disponíveis pro usuário. Quer continuar?</p>
	</div>

	@submit(['label' => 'Sim, deletar evento', 'theme' => 'secondary'])
</form>
@endmodal