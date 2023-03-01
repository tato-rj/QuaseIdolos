<a href="{{route('ratings.live')}}" target="_blank" class="btn btn-secondary w-100">Projetar votação</a>

@if($gig->ratings()->exists())
<div class="mt-3">
	<button id="show-winner" class="btn btn-outline-secondary w-100">@fa(['icon' => 'trophy'])Ver ganhador</button>
	<div style="display: none;">
		<h6>Tem certeza?</h6>
		<div class="d-flex">
			<a href="{{route('ratings.winner.broadcast')}}" data-trigger="loader" class="btn btn-green col mr-1">Sim</a>
			<button id="show-winner-cancel" class="btn btn-red col ml-1">Não</button>
		</div>
	</div>
</div>
@endif