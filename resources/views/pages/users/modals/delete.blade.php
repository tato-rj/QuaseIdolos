@modal(['title' => 'Tem certeza?','id' => 'delete-user-modal'])
<form method="POST" action="{{route('profile.destroy', $user ?? null)}}">
	@csrf
	@method('DELETE')

	<div class="text-left bg-white px-4 py-3 rounded mb-3">
		<p class="text-danger mb-1"><strong>@fa(['icon' => 'exclamation-circle'])Essa ação é irreversível</strong></p>
		<p class="text-dark m-0">A sua conta será deletada imediatamente. Quer continuar?</p>
	</div>

	@submit(['label' => 'Sim, desejo deletar', 'theme' => 'secondary'])
</form>
@endmodal