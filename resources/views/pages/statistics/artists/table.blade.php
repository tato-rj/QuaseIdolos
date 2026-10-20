@include('pages.statistics.components.ranking-title', ['label' => 'artistas mais cantados'])
@table([
  'rows' => $ranking,
  'empty' => true,
  'header' => false,
  'columns' => ['name' => 'Nome', 'count' => 'Quantidade'],
  'view' => 'pages.statistics.artists.row'
])
