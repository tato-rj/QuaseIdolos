@extends('layouts.app', ['title' => 'Equipe'])

@push('header')
<style type="text/css">

</style>
@endpush

@section('content')
<section class="container ">
	<div class="text-center mb-4">
		@pagetitle(['title' => 'Gerencie aqui a', 'highlight' => 'equipe'])
		@searchbar([
			'name' => 'search_member',
			'placeholder' => 'Buscar usuário',
			'url' => route('team.search')])
	</div>

	<div id="results-container"></div>

	<div id="admin-container"> 
		@table([
			'empty' => true,
			'legend' => 'membro|membros',
			'columns' => [
				'status' => 'Status',
				'name' => 'Nome', 
				'instruments' => 'Instrumentos', 
				'manage_events' => 'Controla eventos', 
				'manage_setlist' => 'Controla setlist', 
				'actions' => ''],
			'rows' => $team,
			'view' => 'pages.team.row'
		])
	</div>
</section>


@endsection

@push('scripts')
<script type="text/javascript">
$('input[name="search_member"]').keyup(function() {
	let input = $(this).val();

	if (input.length >= 0 && input.length < 3) {
		$('#results-container').html('');
		$('#admin-container').show();
		return;
	}

	axios.get($(this).data('url'), { params: { input: input } })
		 .then(function(response) {
		 	$('#admin-container').hide();
			$('#results-container').html(response.data);
		 })
		 .catch(function(error) {
		 	$('#admin-container').show();
		 	log(error.response);
			// alert('Try again...');
		});

});
</script>
@endpush