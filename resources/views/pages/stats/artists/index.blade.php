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
      'Artistas' => route('stats.artists'),
      'Estilos' => route('stats.genres')
    ]])
	</div>
  <div class="row">
  	<div class="col-lg-6 col-12">
      <div class="p-6 d-center">
        <div class="text-center">
          <h4 class="mb-3">Artista com mais músicas</h4>
          @include('pages.cardapio.components.artist.avatar', [
            'artist' => $rankingBySongs->shift(),
            'selected' => true
            ])
        </div>
      </div>
  	</div>

    <div class="col-lg-3 col-md-6 col-12 d-flex align-items-center">
      <div>
        @foreach($rankingBySongs->shift(4) as $artist)
        <div class="d-apart mb-3">
          <div class="d-flex align-items-center">
            <img src="{{$artist->coverImage()}}" class="rounded-circle mr-2" style="width: 60px">
            <div>
              <h6 class="m-0">{{$artist->name}}</h6>
              <h6 class="m-0 text-secondary">{{$artist->songs_count}} músicas</h6>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>

    <div class="col-lg-3 col-md-6 col-12 d-flex align-items-center">
      <div>
        @foreach($rankingBySongs as $artist)
        <div class="d-apart mb-3">
          <div class="d-flex align-items-center">
            <img src="{{$artist->coverImage()}}" class="rounded-circle mr-2" style="width: 60px">
            <div>
              <h6 class="m-0">{{$artist->name}}</h6>
              <h6 class="m-0 text-secondary">{{$artist->songs_count}} músicas</h6>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</section>

@endsection

@push('scripts')
<script type="text/javascript">
</script>
@endpush