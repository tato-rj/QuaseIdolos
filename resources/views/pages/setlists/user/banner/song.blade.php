<div class="row">
	<div class="col-lg-6 col-md-10 col-12 mx-auto py-2">
		@if($invitation = $songRequest->invitations()->toMe()->confirmed()->first())
		<div class="px-2 mb-1">
			<span class="badge bg-green rounded-pill py-0">Convidado por {{$invitation->songRequest->user->first_name}}</span>
		</div>
		@endif

		@if($count = $songRequest->invitations()->fromMe()->unconfirmed()->count())
		<div class="px-2 mb-1">
			<span class="badge bg-warning rounded-pill py-0">Esperando {{$count}} @choice('confirmação|confirmações', $count)</span>
		</div>
		@elseif($count = $songRequest->invitations()->fromMe()->confirmed()->count())
		<div class="px-2 mb-1">
			<span class="badge bg-green rounded-pill py-0">@choice('Convite|Convites', $count) @choice('confirmado|confirmados', $count)</span>
		</div>
		@endif

		<div class="d-apart px-2">
			<div class="d-flex align-items-center text-truncate">
				<img src="{{$songRequest->song->artist->coverImage()}}" class="rounded-circle mr-2" style="width: 40px; height: 40px">

				<div class="text-truncate">
					<h5 class="text-dark no-stroke mb-0 mr-2 text-truncate">{{$songRequest->song->name}}</h5>
					<p class="fw-bold m-0 text-dark lh-1 text-truncate"><small>{{$songRequest->song->artist->name}}</small></p>
				</div>
			</div>

			<div class="d-flex">
				@if($songRequest->user->is(auth()->user()))
					@include('pages.setlists.user.banner.buttons.invite')
					@include('pages.setlists.user.banner.buttons.change')
					@include('pages.setlists.user.banner.buttons.cancel')
				@else
					@include('pages.setlists.user.banner.buttons.decline')
				@endif
			</div>
		</div>
	</div>
</div>
