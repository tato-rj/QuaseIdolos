@php($participants = $gig->participants()->guests()->count())
@php($requests = $gig->setlist()->waiting()->count())

@modal(['title' => 'Fechar evento', 'id' => 'close-gig-'.$gig->id.'-modal'])
<form method="POST" action="{{route('gig.close', $gig)}}" class="text-center">
	@csrf

	@if($participants || $requests)
	<div class="text-left bg-white px-4 py-3 rounded mb-4">
		@if($participants)
		<p class="text-warning">@fa(['icon' => 'exclamation-circle']){{$participants}} @choice('pessoa|pessoas', $participants) participando</p>
		@endif

		@if($requests)
		<p class="text-red m-0">@fa(['icon' => 'exclamation-circle']){{$requests}} @choice('pedido|pedidos', $requests) na lista de espera</p>
		@else
		<p class="text-green m-0">@fa(['icon' => 'check-circle'])A lista de espera do setlist está vazia</p>
		@endif
	</div>
	@endif
	
	<h6 class="mb-4">Confirma que o evento acabou?</h6>

	@submit(['label' => 'Fechar evento', 'theme' => 'secondary'])
</form>
@endmodal