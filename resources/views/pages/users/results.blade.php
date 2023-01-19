@table([
	'legend' => 'cantor|cantores',
	'optional' => [3,4,5],
	'headers' => [
		'created_at' => 'Data', 
		'name' => 'Nome', 
		'Pedidos', 
		'Troféus', 
		'Favoritos'],
	'rows' => $users,
	'view' => 'pages.users.row'
])