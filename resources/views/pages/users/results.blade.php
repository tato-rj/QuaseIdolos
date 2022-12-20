@table([
	'legend' => 'cantor|cantores',
	'optional' => [3,4,5],
	'headers' => ['Nome', 'Data', 'Pedidos', 'Troféus', 'Favoritos'],
	'rows' => $users,
	'view' => 'pages.users.row'
])