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
          <h4 class="mb-3">Estilo com mais músicas</h4>
          <div class="d-center flex-column">
            @php($genre = $rankingBySongs->shift())
            <div class="bg-center rounded mb-3" style="height: 120px; width: 210px; background-image: url({{$genre->coverImage()}});"></div>
            <div>
              <h4 class="m-0">{{$genre->name}}</h4>
              <h4 class="m-0 text-secondary">{{$genre->songs_count}} músicas</h4>
            </div>
          </div>
        </div>
      </div>
  	</div>

    <div class="col-lg-3 col-md-6 col-12 d-flex align-items-center">
      <div>
        @foreach($rankingBySongs->shift(4) as $genre)
        <div class="d-apart mb-3">
          <div class="d-flex align-items-center">
            <div class="bg-center rounded mr-3" style="height: 60px; width: 120px; background-image: url({{$genre->coverImage()}});"></div>
            <div>
              <h6 class="m-0">{{$genre->name}}</h6>
              <h6 class="m-0 text-secondary">{{$genre->songs_count}} músicas</h6>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>

    <div class="col-lg-3 col-md-6 col-12 d-flex align-items-center">
      <div>
        @foreach($rankingBySongs as $genre)
        <div class="d-apart mb-3">
          <div class="d-flex align-items-center">
            <div class="bg-center rounded mr-3" style="height: 60px; width: 120px; background-image: url({{$genre->coverImage()}});"></div>
            <div>
              <h6 class="m-0">{{$genre->name}}</h6>
              <h6 class="m-0 text-secondary">{{$genre->songs_count}} músicas</h6>
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