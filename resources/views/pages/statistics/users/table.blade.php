@table([
  'title' => 'Top 10 cantores que mais cantaram',
  'rows' => $ranking,
  'header' => false,
  'columns' => ['name' => 'Nome', 'count' => 'Quantidade'],
  'empty' => true,
  'view' => 'pages.statistics.users.row'
])