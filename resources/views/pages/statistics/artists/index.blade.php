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

  @include('pages.statistics.components.dates', ['empty' => true])

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
  axios.get('{!! route('stats.artists') !!}', {params: {from: from, to: to}})
       .then(function(response) {
        log(response.data);
        $('#table-container').html(response.data);
       })
       .catch(function(error) {
        log(error)
       });
}
</script>
@endpush