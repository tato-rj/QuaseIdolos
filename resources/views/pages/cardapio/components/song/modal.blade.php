@modal([
	'size' => 'lg', 
	'id' => 'song-'.$song->id.'-modal', 
	'class' => 'cardapio-song', 
	'data' => ['url' => route('cardapio.modal', $song)]
])
@slot('header')
@include('pages.cardapio.components.song.header')
@endslot

<div class="cardapio-modal-container">
	@include('components.placeholders.cardapio')
</div>
@endmodal