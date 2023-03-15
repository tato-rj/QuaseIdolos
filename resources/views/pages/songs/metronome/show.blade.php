<div class="d-center flex-column mb-4">
	<div class="d-flex">
		@include('pages.songs.metronome.control', ['icon' => 'minus'])
		<h3 class="m-0 h1 d-center position-relative" data-song-id="{{$song->id}}" id="bpm" style="width: 260px; height: 260px">
			@include('pages.songs.metronome.ring')
			<span>{{$song->bpm}}</span>
		</h3>
		@include('pages.songs.metronome.control', ['icon' => 'plus'])
	</div>
	<div class="d-apart" style="width: 80%">
		@include('pages.songs.metronome.control', ['icon' => 'minus', 'mobile' => true])
		@include('pages.songs.metronome.control', ['icon' => 'plus', 'mobile' => true])
	</div>
</div>

<div class="text-center">
<button data-url="{{route('metronome.update', $song)}}" id="update-tempo" class="btn btn-outline-secondary" style="display: none;">@fa(['icon' => 'save'])Salvar tempo</button>
</div>