@include('pages.statistics.components.ranking-title', ['label' => 'músicas mais cantadas'])
@table([
  'header' => false,
  'columns' => ['name' => 'Nome', 'count' => 'Quantidade'],
  'rows' => $ranking,
  'empty' => true,
  'view' => 'pages.statistics.songs.row'
])
