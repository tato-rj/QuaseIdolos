@table([
	'legend' => 'cantor|cantores',
	'optional' => [3,4,5],
	'headers' => [
		'created_at' => 'Data', 
		'name' => 'Nome', 
		'participations_count' => 'Eventos', 
		'Músicas', 
		'Favoritos'],
	'rows' => $users,
	'view' => 'pages.users.row'
])