@include('pages.statistics.components.ranking-title', ['label' => 'cantores que mais cantaram'])
@table([
  'rows' => $ranking,
  'header' => false,
  'columns' => ['name' => 'Nome', 'count' => 'Quantidade'],
  'empty' => true,
  'view' => 'pages.statistics.users.row'
])
