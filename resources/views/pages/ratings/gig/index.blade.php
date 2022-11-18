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
let seconds = 10;

if (app.gig) {
	getRanking();
}

window.setInterval('counter()', 1000);

function getRanking()
{
    axios.get('{!! route('ratings.ranking') !!}')
         .then(function(response) {
            $('#ranking-container').html(response.data);
            counter();
         })
         .catch(function(error) {
            alert(error);
         });
}

function counter()
{
   if (seconds == 0) {
      getRanking();
      seconds = 10;
   } else {
      $('#counter').text(seconds + 's');
      seconds -= 1;
   }
}
</script>
@endpush