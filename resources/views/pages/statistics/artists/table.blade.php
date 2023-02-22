@table([
  'title' => 'Top 10 artistas mais cantados',
  'rows' => $ranking,
  'empty' => true,
  'header' => false,
  'columns' => ['name' => 'Nome', 'count' => 'Quantidade'],
  'view' => 'pages.statistics.artists.row'
])