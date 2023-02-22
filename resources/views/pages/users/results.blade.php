@table([
	'legend' => 'cantor|cantores',
	'columns' => [
		'created_at*' => 'Data', 
		'name*' => 'Nome', 
		'gender*' => 'Gênero',
		'sent_messages_count*' => 'Chats',
		'participations_count*' => 'Eventos', 
		'song_requests_count*' => 'Músicas'],
	'rows' => $users,
	'view' => 'pages.users.row'
])