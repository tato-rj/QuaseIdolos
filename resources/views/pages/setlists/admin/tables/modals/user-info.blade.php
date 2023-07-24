	<div class="mb-4">
		@include('pages.users.avatar', ['size' => '120px', 'namesize' => '1.2rem', 'margin' => 'mb-1'])
		<h6 class="mb-1">{{$user->email}}</h6>
		<small class="opacity-6">@lang('views/user.created_at') {{$user->created_at->format('d/m/Y')}}</small>
	</div>

	<div class="text-left"> 
		@table([
		'title' => __('views/user.tables.songs'),
		'empty' => true,
		'margin' => 'm-0',
		'padding' => 'py-2 px-3',
		'columns' => ['scheduled_for' => 'Data', 'name' => 'Música'],
		'legend' => 'música|músicas',
		'rows' => $user->songRequests()->completed()->get(),
		'view' => 'pages.users.rows.song'
		])
	</div>