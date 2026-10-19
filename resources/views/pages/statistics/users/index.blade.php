@php($initialDate = carbon(\App\Models\SongRequest::min('created_at')))
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

  <div class="d-flex justify-content-end mb-4">
    @include('pages.statistics.components.dates')
  </div>
  <div id="table-container">
    @include('components.placeholders.table')
  </div>

  <div class="row">
    <div class="col-lg-4 col-md-6 col-12"> 
      @include('pages.statistics.users.charts.pie', [
        'title' => 'Gênero', 
        'chart' => 'gender'])
    </div>
    <div class="col-lg-4 col-md-6 col-12"> 
      @include('pages.statistics.users.charts.pie', [
        'title' => 'Login', 
        'chart' => 'login'])
    </div>
    <div class="col-lg-4 col-md-6 col-12"> 
{{--       @include('pages.statistics.users.charts.pie', [
        'title' => 'Gênero', 
        'id' => 'gigs-chart', 
        'model' => \App\Models\User::class,
        'column' => 'gender']) --}}
    </div>
  </div>
</section>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@include('pages.statistics.components.ranking-script', ['rankingUrl' => route('stats.users')])
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
    chart: $container.data('chart'),
  }, $container.data('target'));
}

function getChartData(options, id)
{
  axios.get(window.location.href, {params: options})
       .then(function(response) {
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
      backgroundColor: records.colors,
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