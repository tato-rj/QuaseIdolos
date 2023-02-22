@table([
	'empty' => true,
	'legend' => 'usuário|usuários',
	'header' => false,
	'columns' => ['name' => 'Nome', 'actions' => ''],
	'rows' => $users,
	'view' => 'pages.team.search.row'
])