@modal(['title' => 'Tem certeza?','id' => 'delete-show-'.$show->id.'-modal'])
@form(['method' => 'DELETE', 'url' => route('shows.destroy', $show), 'data' => ['trigger' => 'loader']])

	<div class="text-left bg-white px-4 py-3 rounded mb-3">
		<p class="text-danger mb-1"><strong>@fa(['icon' => 'exclamation-circle'])Essa ação é irreversível</strong></p>
		<p class="text-dark m-0">Quer continuar?</p>
	</div>

	@submit(['label' => 'Sim, deletar show', 'theme' => 'secondary'])
@endform
@endmodal