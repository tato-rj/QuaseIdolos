<div class="text-center">
	<h6 class="m-0">@fa(['icon' => 'info-circle'])Quer cantar?</h6>
	<p class="">Escolha o evento abaixo</p>
</div>
<a href="{{route('gig.select', ['origin' => route('cardapio.index', ['input' => request()->input])])}}" class="btn btn-secondary text-truncate w-100 mb-3">@fa(['icon' => 'door-open'])ESCOLHER EVENTO</a>
