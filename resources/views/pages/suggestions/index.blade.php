@extends('layouts.app', ['title' => 'Sugestões'])

@push('header')
<style type="text/css">

</style>
@endpush

@section('content')
<section class="container ">
	@pagetitle(['title' => 'Gerencie aqui as', 'highlight' => 'sugestões'])

	@table([
		'empty' => true,
		'legend' => 'sugestão|sugestões',
		'headers' => ['Data', 'Artista', 'Música', ''],
		'optional' => [1],
		'rows' => $suggestions,
		'view' => 'pages.suggestions.row'
	])
</section>


@endsection

@push('scripts')
<script type="text/javascript">
</script>
@endpush