@php($requests = $gig->setlist()->waiting()->count())

@modal(['title' => 'Fechar evento', 'id' => 'close-gig-'.$gig->id.'-modal'])
<form method="POST" action="{{route('gig.close', $gig)}}" class="text-center">
	@csrf

	<div class="text-left bg-white px-4 py-3 rounded mb-3">
		<div class="mb-2">
			@if($gig->participatesInRatings())
				@if($gig->winner()->exists())
					<p class="text-green m-0">@fa(['icon' => 'check-circle'])O vencedor já foi escolhido</p>
				@else
					<p class="text-warning m-0">@fa(['icon' => 'exclamation-circle'])A votação ainda está aberta</p>
				@endif
			@endif

			@if($gig->isFull())
			<p class="text-green m-0">@fa(['icon' => 'check-circle'])O setlist está completo</p>
			@else
			<p class="text-red m-0">@fa(['icon' => 'exclamation-circle'])O setlist ainda tem espaço pra mais músicas</p>
			@endif

			@if($requests)
			<p class="text-red m-0">@fa(['icon' => 'exclamation-circle']){{$requests}} @choice('pedido|pedidos', $requests) na lista de espera</p>
			@else
			<p class="text-green m-0">@fa(['icon' => 'check-circle'])A lista de espera está vazia</p>
			@endif

		</div>

		<p class="text-dark m-0">Confirma que o evento acabou?</p>
	</div>

	@submit(['label' => 'Fechar evento', 'theme' => 'secondary'])
</form>
@endmodal