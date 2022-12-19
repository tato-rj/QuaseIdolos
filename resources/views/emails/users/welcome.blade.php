@component('mail::message')

<h1 class="heading">Olá {{$user->first_name}}!</h1>
@component('mail::panel', ['theme' => 'secondary'])
Obrigado por fazer parte do nosso time! A partir de agora, sempre que chegar em um evento da Quase Ídolos basta fazer o login e começar a se divertir cantando as suas músicas favoritas.
@endcomponent

<h1 class="heading text-primary border-bottom border-bottom-dotted border-light">Qual é o seu artista favorito?</h1>
<div class="text-center"> 
@foreach($artists as $artist)
@include('mail::artist')
@endforeach
</div>

@component('mail::button', ['url' => route('cardapio.index')])
VEJA O NOSSO CARDÁPIO
@endcomponent

Até a próxima,<br>
Equipe do {{ config('app.name') }}
@endcomponent
