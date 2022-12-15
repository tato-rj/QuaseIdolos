@modal(['title' => 'Trocar música', 'size' => 'lg', 'class' => 'song-request', 'id' => 'song-requests-change-'.$entry->id.'-modal'])
<div id="change-song">
	<div class="row"> 
		<div class="col-lg-8 col-md-10 col-12 mx-auto d-flex">
			@include('pages.cardapio.search', [
				'url' => route('cardapio.search', ['song_request_id' => $entry->id]), 
				'table' => 'pages.song-requests.change.table',
				'id' => 'change-song'])
		</div>
	</div>

	<section class="container results-container">

	</section>
</div>
@endmodal