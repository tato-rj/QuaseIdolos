@extends('layouts.app', ['title' => $user->name])

@push('header')
<style type="text/css">
.song-result:nth-child(n+6) {
	display: none;
}
</style>
@endpush

@section('content')
<section class="container py-4">
		@if(! $user->email && auth()->user()->is($user))
		<div class="mx-auto mb-4" style="width: 100%; max-width: 600px"> 
		@alert([
	    'color' => 'red',
	    'headline' => __('views/alert.error'),
	    'message' => __('views/user.missing-email'),
	    'dismissible' => true])
	  </div>
	  @endif
	<div class="row">
		<div class="col-lg-3 col-md-7 mx-auto col-12 text-center mb-4">
			<div class="mb-3">
				@include('pages.users.avatar', ['size' => '180px', 'namesize' => '2rem'])
			</div>

			<div class="d-flex flex-column">
				@if($user->socialAccounts()->exists())
					@include('pages.users.actions.social')
				@endif

				@if($user->hasOwnAvatar())
					@include('pages.users.actions.avatar')
				@endif

				@if($user->socialAccounts()->exists() || $user->hasOwnAvatar())
				@include('layouts.menu.components.divider')
				@endif

				@include('pages.team.actions.edit')
				
				@include('pages.team.actions.unknown-songs')
				
				<form method="POST" action="{{route('team.revoke', $user)}}" class="mb-2">
					@csrf
					@method('DELETE')

					@submit([
						'label' => 'Remover admin status', 
						'theme' => 'outline-secondary',
						'classes' => 'w-100'
						])
				</form>

				<div class="d-center my-2">
					@foreach(['facebook', 'google', 'instagram'] as $provider)
					@fa(['icon' => $provider, 'fa_size' => '2x', 'fa_type' => 'b', 'mr' => 0, 'classes' => $user->socialAccounts()->provider($provider)->exists() ? 'mx-2 opacity-8' : 'mx-2 opacity-2'])
					@endforeach
				</div>
				<small class="opacity-6">@lang('views/user.created_at') {{$user->created_at->format('d/m/Y')}}</small>
			</div>
		</div>

		<div class="col-lg-9 col-12">
			@php($unknownSongs = $user->admin->unknownSongs())

			@if($unknownSongs)
			<div class="bg-transparent px-4 pt-4 pb-3 rounded mb-4">
				<h6 class="text-secondary">@fa(['icon' => 'filter'])Músicas que não conheço</h6>
				<div class="d-flex flex-wrap">
					@forelse($unknownSongs as $song)
					<div class="excluded-song" style="display: {{$loop->remaining > 5 ? 'none' : null}}">
						<div class="border border-secondary bg-dark px-2 py-1 rounded d-flex align-items-center mr-2 mb-2">
							<img src="{{$song->artist->coverImage()}}" class="rounded-circle mr-2" style="width: 33px; height: 33px">
							<h6 class="mb-0 mr-1">{{$song->name}}</h6>
							<button name="unknown_songs" data-url="{{route('team.unknown-songs.update', compact(['user', 'song']))}}" class="btn-raw text-secondary pl-2 pr-1 d-center">@fa(['icon' => 'times', 'mr' => 0, 'fa_size' => '1x'])</button>
						</div>
					</div>
					@empty
					<p class="m-0 opacity-6">Sei tocar todas as {{\App\Models\Song::count()}} músicas</p>
					@endforelse
				</div>

				@if($unknownSongs->count() > 5)
				<div class="text-center border-top mt-2 pt-1 border-secondary">
					<p class="mb-1 opacity-6"><small>Total de {{$unknownSongs->count()}} músicas</small></p>
					<button id="show-all-excluded" class="btn btn-sm btn-secondary p-1">Ver todas</button>
				</div>
				@endif
			</div>
			@endif

			@table([
				'title' => __('views/user.tables.gig'),
				'empty' => true,
				'columns' => ['scheduled_for' => 'Data', 'name' => 'Evento'],
				'legend' => 'evento|eventos',
				'rows' => $user->participations()->confirmed()->latest()->get(),
				'view' => 'pages.users.rows.gigs'
			])
		</div>
	</div>
</section>


@endsection

@push('scripts')
<script type="text/javascript">
$('input[name="search_songs"]').on('keyup', function() {
	let input = $(this).val();

	if (input.length == 0) {
		$('#results-container').html('');
	} else if (input.length >= 3) {
		axios.get($(this).data('url'), {params: {input: input}})
				 .then(function(response) {
				 	$('#results-container').html(response.data);
				 });
	}
});
</script>
<script type="text/javascript">
$(document).on('change, click', '[name="unknown_songs"]', function() {
	let $input = $(this);
	axios.patch($input.data('url'))
			 .then(function(response) {
			 	$input.closest('.excluded-song').remove();
			 	log(response.data);
			 });
});

$('#show-all-excluded').click(function() {
	$('.excluded-song').show();
	$(this).parent().remove();
});
</script>
@endpush