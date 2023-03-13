@modal(['title' => 'Fechar evento', 'id' => 'close-show-'.$show->id.'-modal'])
<form method="POST" action="{{$show->closeRoute()}}" class="text-center">
	@csrf

	<div class="text-left bg-white px-4 py-3 rounded mb-3">
		<p class="text-dark m-0">Confirma que o evento acabou?</p>
	</div>

	@submit(['label' => 'Fechar evento', 'theme' => 'secondary'])
</form>
@endmodal