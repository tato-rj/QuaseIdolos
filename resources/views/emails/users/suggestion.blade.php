@component('mail::message')
# Olá {{$suggestion->user->first_name}}

O seu pedido da música <strong>{{$suggestion->song_name}}</strong> foi confirmado! Vocé já pode escolher a música no nosso cardápio.

@component('mail::button', ['url' => route('cardapio.index')])
VEJA O NOSSO CARDÁPIO
@endcomponent

Obrigado por enviar o seu pedido!

Até a próxima,<br>
Equipe do {{ config('app.name') }}
@endcomponent
