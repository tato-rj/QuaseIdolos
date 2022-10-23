@extends('layouts.app', ['title' => 'Karaokê Ao Vivo'])

@push('header')
<style type="text/css">
.artist img {
	width: 120px;
}

.artist:hover img, .artist[selected] img {
	border: 6px solid white;
}

.artist:not([selected]) {
	width: 160px;
}

.artist:not([selected]) p {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.song-result:hover {
	background: rgba(0,0,0,0.1) !important;
}
</style>
@endpush

@section('content')
<section class="container py-4">
	<div class="text-center">
		<div class="mb-5">
			<img src="{{asset('images/brand/logo_lg.svg')}}" style="max-width: 500px; width: 90%" class="mb-2">
			<h2>NOSSO CARDÁPIO <span class="text-secondary">MUSICAL</span></h2>
		</div>
	</div>
</section>

<section class="container-fluid mb-6 p-0">
	@include('pages.cardapio.search')
	@include('pages.cardapio.results.artists')

	@include('pages.cardapio.results.table')
</section>

@endsection

@push('scripts')
<script type="text/javascript">
function resetArtists()
{
	$('.artist').attr('selected', false).fadeIn();
	$('#artists-container label.intro').show();
	$('#artists-container label.back').hide();
}

function clearResults()
{
	$('#results').hide();
}

function showResults()
{
	$('#results').show();
}

$(document).ready(function(){
	$('.artist').on('click', function() {
		if ($(this).hasAttr('selected')) {
			resetArtists();
			clearResults();
		} else {
			$('.artist').attr('selected', false).not(this).hide();
			$(this).attr('selected', true);
			$('#artists-container label.intro').hide();
			$('#artists-container label.back').show();

			showResults();
		}
	});

	$('#artists-container label.back').on('click', function() {
		resetArtists();
		clearResults();
	});

	$('input[name="search"]').keyup(function() {
		let input = $(this).val();

		if (input.length == 0) {
			resetArtists();
			clearResults();

			$('#artists-container').show();
		} else if (input.length >= 3) {
			$('#artists-container').hide();
			resetArtists();
			log(input);

			showResults();
		}
	});
});
</script>
@endpush