@include('pages.statistics.components.ranking-title', ['label' => 'estilos mais cantados'])
  @table([
    'rows' => $ranking,
    'header' => false,
    'columns' => ['name' => 'Nome', 'count' => 'Quantidade'],
    'empty' => true,
    'view' => 'pages.statistics.genres.row'
  ])
