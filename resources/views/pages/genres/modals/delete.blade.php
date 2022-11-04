@modal(['title' => 'Tem certeza?','id' => 'delete-genre-'.$genre->id.'-modal'])
<form method="POST" action="{{route('genres.destroy', $genre)}}">
	@csrf
	@method('DELETE')

	<div class="text-left bg-white px-4 py-3 rounded mb-3">
		<p class="text-danger mb-1"><strong>@fa(['icon' => 'exclamation-circle'])Essa ação é irreversível</strong></p>
		<p class="text-dark m-0">Todas as músicas relacionadas a esse estilo serão deletas também. Quer continuar?</p>
	</div>

	@submit(['label' => 'Sim, deletar estilo', 'theme' => 'secondary'])
</form>
@endmodal