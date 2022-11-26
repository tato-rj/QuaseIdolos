@component('mail::message')
<div class="text-center mb-4">
<h1 class="text-center text-primary text-uppercase mb-3 font-brand" style="font-size: 1.4rem">Parabéns {{$winner->user->first_name}}!!</h1>
<img src="{{asset('images/music-award.png')}}" width="200" class="mb-3">
<h1 class="text-center m-0" style="font-size: 1.6rem">Você ganhou o 1<sup>o</sup> lugar cantando</h1>
</div>

<div class="d-center mb-4">
<img src="http://quaseidolos.test/storage/artists/babado.jpeg" width="70" class="rounded-circle mr-2">
<div>
<h1 style="font-size: 1.4rem" class="m-0">{{$winner->song->name}}</h1>
<h2 class="m-0">{{$winner->song->artist->name}}</h2>
</div>
</div>

Obrigado por participar do evento <strong>{{$winner->gig->name}}</strong> com a banda Quase Ídolos, esperamos ver você cantando com a gente de novo em breve.

Até a próxima,<br>
Equipe do {{ config('app.name') }}
@endcomponent
