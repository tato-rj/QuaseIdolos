<button data-bs-toggle="modal" data-bs-target="#screens-modal" class="btn btn-secondary mb-3">@fa(['icon' => 'share-alt'])Projetar no telão</button>

@modal(['title' => 'Projetar','id' => 'screens-modal', 'size' => 'sm'])
	<div>
		@if($gig->password()->required())
		<a class="btn btn-secondary mb-3 w-100" target="_blank" href="{{route('gig.password', $gig)}}">Senha</a>
		@endif
		<a class="btn btn-secondary mb-3 w-100" target="_blank" href="{{route('lyrics.index')}}">Letras</a>
		<a href="{{route('ratings.live')}}" target="_blank" class="btn btn-secondary w-100 mb-3">Votação</a>
		<div>
			<button id="show-winner" class="btn btn-secondary w-100">@fa(['icon' => 'trophy'])Ver ganhador</button>
			<div style="display: none;">
				<h6>Tem certeza?</h6>
				<div class="d-flex">
					<a href="{{route('ratings.winner.broadcast')}}" data-trigger="loader" class="btn btn-green col mr-1">Sim</a>
					<button id="show-winner-cancel" class="btn btn-red col ml-1">Não</button>
				</div>
			</div>
		</div>
	</div>
@endmodal