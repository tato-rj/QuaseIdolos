@extends('layouts.app', ['title' => 'Karaokê Ao Vivo'])

@push('header')
<style type="text/css">
</style>
@endpush

@section('content')
<div id="cardapio">
	<section class="container">
		@pagetitle(['title' => 'Nosso cardápio', 'highlight' => 'musical'])
		<div class="row"> 
			<div class="col-lg-5 col-md-8 col-12 mx-auto d-flex">
				@include('pages.cardapio.search', ['url' => route('cardapio.search'), 'id' => 'cardapio'])
			</div>
		</div>
	</section>

	<section class="container-fluid">
		@include('pages.cardapio.genres')

		@include('pages.cardapio.artists', ['withlinks' => true])
	</section>

	<section id="results" class="container">
		@include('pages.cardapio.results.table')
	</section>
</div>
@endsection

@push('scripts')
<script type="text/javascript" src="{{asset('js/vendor/jquery.jscroll.min.js')}}"></script>
<script type="text/javascript">
$('ul.pagination').hide();

enableScroll();
</script>
<script type="text/javascript">
$(document).on('click', 'button[name="change-song"]', function() {
	$($(this).data('target-hide')).toggle();
	$($(this).data('target-show')).toggle();
});
</script>
@endpush