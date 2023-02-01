@component('mail::message')
<div class="text-center mb-3">
<h1 class="heading text-primary m-0 lh-1" style="font-size: 2rem">Parabéns {{$user->first_name}}!!</h1>
<h4 class="m-0 mb-4">Você ganhou o <strong><u>1° Lugar</u></strong> na votação de hoje</h4>
<img src="{{asset('images/music-award.png')}}" width="200" class="mb-3">
</div>

<div class="d-center mb-4">
<img src="{{$winner->song->artist->coverImage()}}" width="70" class="rounded-circle mr-2">
<div>
<h1 class="heading m-0 lh-1">{{$winner->song->name}}</h1>
<h2 class="m-0 lh-1" style="opacity: .5"><strong>{{$winner->song->artist->name}}</strong></h2>
</div>
</div>

{{-- @include('mail::list', [
	'theme' => 'secondary', 
	'items' => [
		'EVENTO' => $winner->gig->name(),
		'DATA' => $winner->dateForHumans,
		'RANKING' => '1° Lugar',
		'PARTICIPANTES' => $ranking->votersCount . ' cantores',
		'VOTOS RECEBIDOS' => $ranking->ratings->first()->count . ' votos'
	]
]) --}}

<p>Obrigado por participar do evento <strong>{{$winner->gig->name()}}</strong> com a banda Quase Ídolos, esperamos ver você cantando com a gente de novo em breve.</p>

Até a próxima,<br>
Equipe do {{ config('app.name') }}
@endcomponent
