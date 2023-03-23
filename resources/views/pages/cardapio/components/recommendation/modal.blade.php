<button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#recommendation-modal">@fa(['icon' => 'magic'])Que tal um desafio?</button>

@modal([
	'size' => 'lg', 
	'title' => 'Desafio',
	'id' => 'recommendation-modal',
	'data' => ['url' => route('recommendations.choices')]
])
<div id="recommendation-container">
	<p class="text-center mb-4"><span class="opacity-6">Escolha abaixo as</span> <span class="h5 fw-bold">5</span> <span class="opacity-6">músicas que você mais gosta dessa lista:</span></p>
	
	<div id="recommendation-choices" class="row justify-content-center mb-3"></div>
	
	<div id="recommendation-placeholder">
		<div class="row justify-content-center">
			@include('components.placeholders.recommendation')
		</div>
	</div>
</div>
@endmodal