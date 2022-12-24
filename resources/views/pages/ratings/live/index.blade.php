@extends('layouts.app', ['title' => 'Votação', 'raw' => true])

@push('header')
<style type="text/css">

</style>
@endpush

@section('content')
<div id="page-container">
   <section class="container-fluid mb-6 pt-5 position-relative">
   	@pagetitle(['title' => 'Votação ', 'highlight' => 'ao vivo'])
      
   {{--    <button data-bs-toggle="modal" data-bs-target="#confirm-winner-modal" class="btn btn-secondary mx-auto mb-4">Ver ganhador</button>

      @modal(['title' => 'Tem certeza?','id' => 'confirm-winner-modal'])
         <div class="text-left bg-white px-4 py-3 rounded mb-3">
            <p class="text-danger mb-1"><strong>@fa(['icon' => 'exclamation-circle'])Atenção</strong></p>
            <p class="text-dark mb-1">Ao continuar a votação desse evento será encerrada.</p>
            <p class="text-dark m-0">Quer continuar?</p>
         </div>
         <a href="{{route('ratings.winner')}}" class="btn btn-secondary">Sim, ver ganhador</a>
      @endmodal --}}

   	<div id="ranking-container">

   	</div>
   </section>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
let seconds = {{$timer}};

if (app.gig) {
	getRanking();
   listenToWinnerEvent();
}

function listenToWinnerEvent()
{
   window.Echo
      .channel('winner.gig.' + app.gig.id)
      .listen('WinnerAnnounced', function(event) {
         window.location.href = event.url;
      });
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
   if ($('#ranking-container').length) {
      if (seconds == 0) {
         getRanking();
         seconds = {{$timer}};
      } else {
         $('#counter').text(seconds + 's');
         seconds -= 1;
      }
   }
}
</script>
@endpush