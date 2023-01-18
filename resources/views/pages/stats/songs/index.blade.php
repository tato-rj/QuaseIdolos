@extends('layouts.app', ['title' => 'Estatísticas'])

@push('header')
<style type="text/css">
</style>
@endpush

@section('content')
<section class="container mb-6">
	<div class="text-center mb-4">
		@pagetitle(['title' => 'Estatísticas do', 'highlight' => 'Quaseídolos'])
    @nav(['pages' => [
      'Eventos' => route('stats.gigs'), 
      'Músicas' => route('stats.songs'),
      'Artistas' => route('stats.artists'),
      'Estilos' => route('stats.genres')
    ]])
	</div>

  @table([
    'title' => 'Top 10 músicas mais cantadas',
    'rows' => $ranking,
    'view' => 'pages.stats.songs.row'
  ])
</section>

@endsection

@push('scripts')
<script type="text/javascript">
</script>
@endpush