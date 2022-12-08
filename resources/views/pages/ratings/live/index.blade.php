@extends('layouts.app', ['title' => 'Votação', 'raw' => true])

@push('header')
<style type="text/css">

</style>
@endpush

@section('content')
<section class="container-fluid mb-6 pt-5 position-relative">
	@pagetitle(['title' => 'Votação ', 'highlight' => 'ao vivo'])
   <div class="text-center">
      <button data-bs-toggle="modal" data-bs-target="#confirm-winner-modal" class="btn btn-secondary mx-auto mb-4">Ver ganhador</button>

      @modal(['title' => 'Tem certeza?','id' => 'confirm-winner-modal'])
         <h2 class="text-center no-stroke text-secondary">@fa(['icon' => 'exclamation-circle', 'mr' => 0])</h2>
         <div class="rounded bg-white p-3 mb-4 text-left text-primary">
            <h6 class="no-stroke">Ao continuar a votação desse evento será encerrada.</h6>
            <h6 class="no-stroke m-0">Pode continuar?</h6>
         </div>
         <a href="{{route('ratings.winner')}}" class="btn btn-secondary">Sim, ver ganhador</a>
      @endmodal
   </div>

	<div id="ranking-container" class="row">

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
            log(response.data == $('#ranking-container').html());
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