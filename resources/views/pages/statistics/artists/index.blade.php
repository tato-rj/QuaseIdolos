@php($initialDate = \App\Models\SongRequest::first()->created_at)
@php($firstDate = now()->startOfMonth())
@php($lastDate = now())

@extends('layouts.app', ['title' => 'Estatísticas dos artistas'])

@push('header')
<style type="text/css">
</style>
<script type="text/javascript">
window.dates = <?php echo json_encode([
    'initial' => $initialDate,
    'last' => $lastDate
  ]); ?>
</script>
@endpush

@section('content')
<section class="container mb-6">
	<div class="text-center mb-4">
		@pagetitle(['title' => 'Estatísticas do', 'highlight' => 'Quaseídolos'])
    @include('pages.statistics.nav')
	</div>

  <div class="d-flex justify-content-end mb-4">
    @include('pages.statistics.components.dates')
  </div>

  <div id="table-container">
    @include('pages.statistics.artists.table')
  </div>
</section>

@endsection

@push('scripts')
<script type="text/javascript">
$(".datepicker").datepicker({
    changeMonth: true,
    changeYear: true,
    minDate: new Date('{!! $initialDate !!}'),
    maxDate: new Date('{!! $lastDate !!}'),
    onSelect: function(dateText) {
      let $inputs = $(this).parent().find('.datepicker');
      let from = $inputs.eq(0).val();
      let to = $inputs.eq(1).val()

      if (from && to)
        reloadTable(from, to);
    }
});

function reloadTable(from, to)
{
  $('#table-container').addClass('opacity-6');

  axios.get('{!! route('stats.artists') !!}', {params: {from: from, to: to}})
       .then(function(response) {
        log(response.data);
        $('#table-container').removeClass('opacity-6').html(response.data);
       })
       .catch(function(error) {
        log(error)
       });
}
</script>
@endpush