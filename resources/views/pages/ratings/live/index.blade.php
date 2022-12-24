@extends('layouts.app', ['title' => 'Votação', 'raw' => true])

@push('header')
<style type="text/css">

</style>
@endpush

@section('content')
<section class="container-fluid mb-6 pt-5 position-relative">
	@pagetitle(['title' => 'Votação ', 'highlight' => 'ao vivo'])
	<div id="ranking-container">

	</div>
</section>

@endsection

@push('scripts')
<script type="text/javascript">
let seconds = {{$timer}};

if (app.gig) {
	getRanking();
}

window.setInterval('counter()', 1000);

function getRanking()
{
    axios.get("{{ route('ratings.votes') }}", {params: {timer: "{{$timer}}"}})
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
      seconds = {{$timer}};
   } else {
      $('#counter').text(seconds + 's');
      seconds -= 1;
   }
}
</script>
@endpush