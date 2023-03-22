@foreach($choices as $song)
@include('pages.cardapio.components.recommendation.song')
@endforeach

<div id="get-recommendations" class="position-fixed bottom-0 left-0 w-100 pb-4 animate__slow animate__animated animate__bounceInUp" style="display: none">
	<button class="btn btn-secondary shadow-lg" data-url="{{route('recommendations.get')}}">@fa(['icon' => 'magic'])Quero ver o resultado</button>
</div>