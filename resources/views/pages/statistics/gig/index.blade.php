@php($initialDate = \App\Models\SongRequest::first()->created_at)
@php($firstDate = now()->startOfMonth())
@php($lastDate = now())

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
  	<div class="col-lg-6 col-md-8 col-12">
      @include('pages.statistics.gig.chart', [
        'title' => 'Número de eventos', 
        'id' => 'gigs-chart', 
        'model' => \App\Models\Gig::class,
        'column' => 'scheduled_for'])
  	</div>
    <div class="col-lg-6 col-md-8 col-12">
      @include('pages.statistics.gig.chart', [
        'title' => 'Número de participantes', 
        'id' => 'participants-chart', 
        'model' => \App\Models\Participant::class,
        'column' => 'created_at'])
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

$('.chart-container select[name="group_by"]').on('change', function() {
  reloadChart(this);
});

$(".datepicker").datepicker({
    changeMonth: true,
    changeYear: true,
    minDate: new Date('{!! $initialDate !!}'),
    maxDate: new Date('{!! $lastDate !!}'),
    onSelect: function(dateText) {
      reloadChart(this);
    }
});

function reloadChart(element)
{
  let $container = $(element).closest('.chart-container');

  getChartData({
    model: $container.data('model'),
    column: $container.data('column'),
    group_by: $container.find('select[name="group_by"] option:selected').val(),
    from: $container.find('input[name="from"]').val(),
    to: $container.find('input[name="to"]').val()
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
  type: 'bar',
  data: {
    labels: records.labels,
    datasets: [{
      backgroundColor: '#f2cd3d',
      data: records.data,
      borderWidth: 1,
      maxBarThickness: 40
    }]
  },
  options: {
    plugins: {
      legend: {
        display: false
      }
    },
    scales: {
      y: {
        beginAtZero: true,
        ticks: {
          precision: 0
        }
      }
    }
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