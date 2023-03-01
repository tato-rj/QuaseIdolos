<div class="d-center flex-column">
	<div class="d-flex">
		@include('pages.songs.metronome.control', ['icon' => 'minus'])
		<h3 class="m-0 h1 d-center position-relative" id="bpm" style="width: 360px; height: 360px">
			@include('pages.songs.metronome.ring')
			<span></span>
		</h3>
		@include('pages.songs.metronome.control', ['icon' => 'plus'])
	</div>
	<div class="d-apart" style="width: 80%">
		@include('pages.songs.metronome.control', ['icon' => 'minus', 'mobile' => true])
		@include('pages.songs.metronome.control', ['icon' => 'plus', 'mobile' => true])
	</div>
</div>