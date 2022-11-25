@php($participants = $gig->participants()->guests()->count())
@php($requests = $gig->setlist()->waiting()->count())

@modal(['title' => 'Fechar evento', 'id' => 'close-gig-'.$gig->id.'-modal'])
<form method="POST" action="{{route('gig.close', $gig)}}" class="text-center">
	@csrf

	@if($participants || $requests)
	<div class="text-left bg-white px-4 py-3 rounded mb-4">
		<p class="text-danger mb-1"><strong>@fa(['icon' => 'exclamation-circle'])Esse evento ainda tem</strong></p>
		@if($participants)
		<p class="text-dark m-0">{{$participants}} @choice('pessoa|pessoas', $participants) participando</p>
		@endif
		@if($requests)
		<p class="text-dark m-0">{{$requests}} @choice('pedido|pedidos', $requests) na lista de espera</p>
		@endif
	</div>
	@endif
	
	<h6 class="mb-4">Confirma que o evento acabou?</h6>

	@submit(['label' => 'Fechar evento', 'theme' => 'secondary'])
</form>
@endmodal