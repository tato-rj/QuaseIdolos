<div class="offset-lg-1 col-lg-4 col-md-4 col-12">
	<div class="mb-4">
		<h6 class="text-secondary">@fa(['icon' => 'calendar-day'])Dia do evento</h6>
		<h6>{{$gig->dateForHumans()}}</h6>
	</div>

	<div class="mb-4">
		@php($count = $gig->songs_limit)
		<h6 class="text-secondary">@fa(['icon' => 'lock'])Limite de músicas</h6>
		<h6>Máximo de {{$count}} @choice('música|músicas', $count)</h6>
	</div>

	<div class="mb-4">
		@php($count = $gig->songs_limit_per_user)
		<h6 class="text-secondary">@fa(['icon' => 'user-lock'])Limite por usuário</h6>
		<h6>{{$count}} @choice('música|músicas', $count) por pessoa</h6>
	</div>
</div>
<div class="col-lg-4 col-md-4 col-12">
	<div class="mb-4">
		@php($count = $gig->repeat_limit)
		<h6 class="text-secondary">@fa(['icon' => 'redo'])Número de músicas repetidas</h6>
		<h6>
			@if(is_null($count))
			Sem limite
			@else
			{{$count}} @choice('repetição|repetições', $count) por música
			@endif
		</h6>
	</div>

	<div class="mb-4">
		<h6 class="text-secondary">@fa(['icon' => 'key'])Tipo de evento</h6>
		<h6>Evento {{$gig->isPrivate() ? 'fechado' : 'aberto'}}</h6>
	</div>

	<div class="mb-4">
		<h6 class="text-secondary">@fa(['icon' => 'trophy'])Votação</h6>
		<h6>{{$gig->participatesInRatings() ? 'Aberto a votação' : 'Sem votação'}}</h6>
	</div>
</div>
