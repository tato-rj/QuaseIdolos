<button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#recommendation-modal">@fa(['icon' => 'magic'])Quero uma recomencação</button>

@modal([
	'size' => 'lg', 
	'title' => 'Recomendação',
	'id' => 'recommendation-modal',
	'data' => ['url' => '']
])
<div id="recommendation-container">
	<p class="text-center mb-4"><span class="opacity-6">Escolha abaixo as</span> <u>3</u> <span class="opacity-6">músicas que você mais gosta dessa lista:</span></p>
	
	<div class="row justify-content-center mb-3">
		@foreach($choices as $song)
		@include('pages.cardapio.components.recommendation.song')
		@endforeach
	</div>

	<button id="get-recommendations" class="btn btn-secondary" data-url="{{route('recommendations.get')}}" style="display: none">Escolhe uma música pra mim</button>
</div>
@endmodal