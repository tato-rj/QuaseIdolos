@modal(['title' => 'Trocar música', 'size' => 'lg', 'class' => 'song-request', 'id' => 'song-requests-change-'.$entry->id.'-modal'])
<div>
	<div class="row"> 
		<div class="col-lg-8 col-md-10 col-12 mx-auto d-flex">
			@include('pages.cardapio.search', [
				'url' => route('cardapio.search', ['song_request_id' => $entry->id]), 
				'table' => 'pages.song-requests.change.table',
				'target' => 'change-results'])
		</div>
	</div>

	<div id="change-results" class="container"></div>
</div>
@endmodal