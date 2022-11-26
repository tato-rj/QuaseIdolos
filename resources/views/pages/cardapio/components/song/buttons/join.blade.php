<div class="text-center">
	<h6 class="m-0 text-secondary">@fa(['icon' => 'info-circle'])Quer cantar?</h6>
	<p class="">Escolha um evento</p>
</div>
<a href="{{route('gig.select', ['origin' => route('cardapio.index', ['input' => request()->input])])}}" class="btn btn-secondary text-truncate w-100 mb-3">@fa(['icon' => 'door-open'])ESCOLHER EVENTO</a>
