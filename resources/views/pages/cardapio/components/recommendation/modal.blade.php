<button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#recommendation-modal">@fa(['icon' => 'magic'])Quero uma recomencação</button>

@modal([
	'size' => 'lg', 
	'title' => 'Recomendação',
	'id' => 'recommendation-modal',
	'data' => ['url' => '']
])
<div id="recommendation-container">
	<p class="text-center mb-4"><span class="opacity-6">Escolha abaixo as</span> <span class="h5">5</span> <span class="opacity-6">músicas que você mais gosta dessa lista:</span></p>
	
	<div class="row justify-content-center mb-3">
		@foreach($choices as $song)
		@include('pages.cardapio.components.recommendation.song')
		@endforeach
	</div>

	<div id="get-recommendations" class="position-fixed bottom-0 left-0 w-100 pb-4 animate__animated animate__bounceInUp" style="display: none">
		<button class="btn btn-secondary" data-url="{{route('recommendations.get')}}">Escolhe uma música pra mim</button>
	</div>
</div>
@endmodal