@extends('layouts.app', ['title' => 'Estatísticas'])

@push('header')
<style type="text/css">
</style>
@endpush

@section('content')
<section class="container mb-6">
	<div class="text-center mb-4">
		@pagetitle(['title' => 'Estatísticas do', 'highlight' => 'Quaseídolos'])
    @include('pages.statistics.nav')
	</div>

  @table([
    'title' => 'Top 10 artistas mais cantados',
    'rows' => $ranking,
    'view' => 'pages.statistics.artists.row'
  ])
</section>

@endsection

@push('scripts')
<script type="text/javascript">
</script>
@endpush