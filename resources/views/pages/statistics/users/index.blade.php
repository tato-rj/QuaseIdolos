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

  <div class="row">
    <div class="col-lg-8 col-md-6 col-12"> 
      @table([
        'title' => 'Top 10 cantores que mais cantaram',
        'rows' => $ranking,
        'view' => 'pages.statistics.users.row'
      ])
    </div>
    <div class="col-lg-4 col-md-6 col-12"> 
      @include('pages.statistics.users.charts.gender', [
        'title' => 'Gênero', 
        'id' => 'gigs-chart', 
        'model' => \App\Models\User::class,
        'column' => 'gender'])
    </div>
  </div>
</section>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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