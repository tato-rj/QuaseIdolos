@component('mail::message')
# Olá {{$user->first_name}}

Obrigado por fazer parte do nosso time! A partir de agora, sempre que chegar num evento da Quase Ídolos basta fazer o login e começar a cantar as suas músicas favoritas.

@component('mail::button', ['url' => route('cardapio.index')])
VEJA O NOSSO CARDÁPIO
@endcomponent

Até a próxima,<br>
Equipe do {{ config('app.name') }}
@endcomponent
