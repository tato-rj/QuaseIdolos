@php($excludedSongs = $gig->excludedSongs())

<div class="offset-lg-1 col-lg-8 col-md-8 col-12">
	<div class="bg-transparent px-4 pt-4 pb-3 rounded mb-4">
		<h6 class="text-secondary">@fa(['icon' => 'filter'])Músicas excluídas</h6>
		<div class="d-flex flex-wrap">
			@forelse($excludedSongs as $song)
			<div class="excluded-song" style="display: {{$loop->remaining > 5 ? 'none' : null}}">
				<div class="border border-secondary bg-dark px-2 py-1 rounded d-flex align-items-center mr-2 mb-2">
					<img src="{{$song->artist->coverImage()}}" class="rounded-circle mr-2" style="width: 33px; height: 33px">
					<h6 class="mb-0 mr-1">{{$song->name}}</h6>
					<button name="excluded_songs" data-url="{{route('gig.excluded-songs.update', compact(['gig', 'song']))}}" class="btn-raw text-secondary pl-2 pr-1 d-center">@fa(['icon' => 'times', 'mr' => 0, 'fa_size' => '1x'])</button>
				</div>
			</div>
			@empty
			<h6 class="m-0 opacity-4">Todas as {{\App\Models\Song::count()}} músicas estão disponíveis</h6>
			@endforelse
		</div>

		@if($excludedSongs->count() > 5)
		<div class="text-center border-top mt-2 pt-1 border-secondary">
			<p class="mb-1 opacity-6"><small>Total de {{$excludedSongs->count()}} músicas</small></p>
			<button id="show-all-excluded" class="btn btn-sm btn-secondary p-1">Ver todas</button>
		</div>
		@endif
	</div>

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
