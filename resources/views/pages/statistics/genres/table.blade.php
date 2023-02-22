  @table([
    'title' => 'Top 10 estilos mais cantados',
    'rows' => $ranking,
    'header' => false,
    'columns' => ['name' => 'Nome', 'count' => 'Quantidade'],
    'empty' => true,
    'view' => 'pages.statistics.genres.row'
  ])