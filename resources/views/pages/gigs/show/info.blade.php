<div class="offset-lg-1 col-lg-8 col-md-8 col-12">
	<div class="row">
		@if($gig->password()->required())
		<div class="col-12 mb-4">
			<div class="d-apart bg-transparent px-3 py-2 rounded">
				<h6 class="text-secondary m-0">@fa(['icon' => 'key'])Senha pra entrar</h6>
				<h6 class="m-0">{{$gig->password}}</h6>
			</div>
		</div>
		@endif
		<div class="col-lg-6 col-md-6 col-12 px-4">
			<div class="mb-4">
				<h6 class="text-secondary">@fa(['icon' => 'calendar-day'])Dia do evento</h6>
				<h6>{{$gig->dateForHumans()}}</h6>
			</div>

			@if($gig->duration)
			<div class="mb-4">
				<h6 class="text-secondary">@fa(['icon' => 'calendar-day'])Duração</h6>
				<h6><u>Termina automaticamente</u> após {{$gig->duration}} @choice('hora|horas', $gig->duration)</h6>
			</div>
			@endif

			@if($gig->musicians()->exists())
			<div class="mb-4">
				<h6 class="text-secondary">@fa(['icon' => 'guitar'])Banda</h6>
				<h6>{{arrayToSentence($gig->musicians->pluck('admin.user.first_name')->toArray())}}</h6>
			</div>
			@endif
			
			<div class="mb-4">
				@php($count = $gig->songs_limit)
				<h6 class="text-secondary">@fa(['icon' => 'lock'])Limite total de músicas</h6>
				@if($count)
				<h6>Total de {{$count}} @choice('música|músicas', $count)</h6>
				@else
				<h6 class="opacity-6">Sem limite</h6>
				@endif
			</div>

			<div class="mb-4">
				@php($count = $gig->set_limit)
				<h6 class="text-secondary">@fa(['icon' => 'lock'])Limite de músicas por set</h6>
				@if($count)
				<h6>{{$count}} @choice('música|músicas', $count) por set</h6>
				@else
				<h6 class="opacity-6">Sem limite</h6>
				@endif
			</div>

			<div class="mb-4">
				@php($count = $gig->songs_limit_per_user)
				<h6 class="text-secondary">@fa(['icon' => 'user-lock'])Limite por usuário</h6>
				@if($count)
				<h6>{{$count}} @choice('música|músicas', $count) por pessoa</h6>
				@else
				<h6 class="opacity-6">Sem limite</h6>
				@endif
			</div>
		</div>
		<div class="col-lg-6 col-md-6 col-12 px-4">
			<div class="mb-4">
				@php($count = $gig->repeat_limit)
				<h6 class="text-secondary">@fa(['icon' => 'redo'])Repetições por música</h6>
				<h6>
					@if(is_null($count))
					Sem limite
					@else
					{{$count}} @choice('repetição|repetições', $count) @choice('permitida|permitidas', $count)
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

			<div class="mb-4">
				<h6 class="text-secondary">@fa(['icon' => 'comments'])Chat</h6>
				<h6>{{$gig->participatesInChats() ? 'Chat liberado' : 'Sem chat'}}</h6>
			</div>
		</div>
	</div>
</div>
