@php($initialDate = \App\Models\SongRequest::first()->created_at)
@php($firstDate = now()->startOfMonth())
@php($lastDate = now())

@extends('layouts.app', ['title' => 'Estatísticas dos usuários'])

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

  <div class="row">
    <div class="col-lg-4 col-md-6 col-12"> 
      @include('pages.statistics.users.charts.gender', [
        'title' => 'Gênero', 
        'id' => 'gigs-chart', 
        'model' => \App\Models\User::class,
        'column' => 'gender'])
    </div>
    <div class="col-lg-8 col-md-6 col-12">
      <div class="d-flex justify-content-end mb-4">
        @include('pages.statistics.components.dates')
      </div>
      <div id="table-container"></div>
    </div>
  </div>
</section>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script type="text/javascript">
reloadTable(new Date('{!! $firstDate !!}'), new Date('{!! $lastDate !!}'));

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

  axios.get('{!! route('stats.users') !!}', {params: {from: from, to: to, type: 'ranking'}})
       .then(function(response) {
        log(response.data);
        $('#table-container').removeClass('opacity-6').html(response.data);
       })
       .catch(function(error) {
        log(error)
       });
}
</script>
<script type="text/javascript">
Chart.defaults.color = 'white';
let charts = [];

$('.chart-container').each(function() {
  reloadChart(this);
});

function reloadChart(element)
{
  let $container = $(element).closest('.chart-container');

  getChartData({
    data: 'genre',
    model: $container.data('model'),
    column: $container.data('column')
  }, $container.data('target'));
}

function getChartData(options, id)
{
  axios.get(window.location.href, {params: options})
       .then(function(response) {
        log(response.data);
        renderChart(response.data, id);
       })
       .catch(function(error) {
        alert(error);
       });
}

function renderChart(records, id)
{
  destroy(id);

  chart = new Chart($(id), {
  type: 'pie',
  data: {
    labels: records.labels,
    datasets: [{
      backgroundColor: ['#ec4899', '#0ea5e9'],
      data: records.data,
    }]
  },
  options: {
    // scales: {
    //   y: {
    //     beginAtZero: true,
    //     ticks: {
    //       precision: 0
    //     }
    //   }
    // }
  }
  });

  charts.push({id: id, chart: chart});
}

function destroy(id)
{
  let index = charts.findIndex(object => object.id === id);

  if (index >= 0) {
    charts[index].chart.destroy();
    charts.splice(index, 1);
  }
}
</script>
@endpush