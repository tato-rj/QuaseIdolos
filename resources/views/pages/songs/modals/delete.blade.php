@modal(['title' => 'Tem certeza?','id' => 'delete-song-'.$song->id.'-modal'])
<form method="POST" action="{{route('songs.destroy', $song)}}" class="text-center">
	@csrf
	@method('DELETE')

	<div class="text-left bg-white px-4 py-3 rounded mb-3">
		<p class="text-danger mb-1"><strong>@fa(['icon' => 'exclamation-circle'])Essa ação é irreversível</strong></p>
		<p class="text-dark m-0">Todas registros relacionadas a essa música serão deletos também. Quer continuar?</p>
	</div>

	@submit(['label' => 'Sim, deletar música', 'theme' => 'secondary'])
</form>
@endmodal