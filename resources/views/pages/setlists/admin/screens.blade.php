<button data-bs-toggle="modal" data-bs-target="#screens-modal" class="btn btn-secondary mb-3">@fa(['icon' => 'share-alt'])Projetar no telão</button>

@modal(['title' => 'Projetar','id' => 'screens-modal', 'size' => 'sm'])
	<div>
		<a class="btn btn-secondary mb-3 w-100" target="_blank" href="{{route('lyrics.index')}}">Letras</a>
		<a href="{{route('ratings.live')}}" target="_blank" class="btn btn-secondary w-100">Votação</a>
		<a href="{{route('ratings.winner')}}" target="_blank" class="btn btn-secondary">Sim, ver ganhador</a>
	</div>
@endmodal