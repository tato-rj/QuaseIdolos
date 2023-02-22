@table([
  'title' => 'Top 10 músicas mais cantadas',
  'header' => false,
  'columns' => ['name' => 'Nome', 'count' => 'Quantidade'],
  'rows' => $ranking,
  'empty' => true,
  'view' => 'pages.statistics.songs.row'
])