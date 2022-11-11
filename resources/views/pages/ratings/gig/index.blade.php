@extends('layouts.app', ['title' => 'Votação'])

@push('header')
<style type="text/css">

</style>
@endpush

@section('content')
<section class="container mb-6">
	@include('components.pagetitle', ['title' => 'Ranking de ', 'highlight' => 'hoje'])

	<div id="ranking-container">

	</div>
</section>

@endsection

@push('scripts')
<script type="text/javascript">
</script>

<script type="text/javascript">
if (app.gig) {
	getRanking();
	listenToRatingsEvent();
}

function listenToRatingsEvent()
{
	window.Echo
      .channel('ratings.gig.' + app.gig.id)
      .listen('ScoreSubmitted', function(event) {
      	log(event);
      	getRanking();
      });
}

function getRanking()
{
    axios.get('{!! route('ratings.ranking') !!}')
         .then(function(response) {
            $('#ranking-container').html(response.data);
         })
         .catch(function(error) {
            alert(error);
         });
}
</script>
@endpush