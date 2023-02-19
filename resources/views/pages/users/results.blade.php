@table([
	'legend' => 'cantor|cantores',
	'optional' => [3,4,5],
	'headers' => [
		'created_at' => 'Data', 
		'name' => 'Nome', 
		'gender' => 'Gênero',
		'participations_count' => 'Eventos', 
		'song_requests_count' => 'Músicas',
		'all_messages_count' => 'Chat'],
	'rows' => $users,
	'view' => 'pages.users.row'
])