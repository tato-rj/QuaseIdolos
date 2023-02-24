@php($song = $row->song)

@responsiveRow
  @slot('column1')
	  <div class="d-flex align-items-center">
	  	<div class="mr-2">
			@foreach($row->singers() as $user)
				<div class="position-relative" style="margin-left: {{! $loop->first ? '-16px' : null}}; z-index: {{$loop->remaining}};">
			      @if($user->hasAvatar())
			      @include('components.avatar.image', ['size' => '46px'])
			      @else
			      @include('components.avatar.initial', ['size' => '46px'])
			      @endif
			  </div>
			@endforeach
		</div>
	  	<div>
			  <div>
					{{$song->name}}
				</div>
				<div class="text-secondary">
					{{$song->artist->name}}
				</div>
			</div>
		</div>
  @endslot

  @slot('actions')
  <div class="d-flex justify-content-end">
	<div class="rating">
			<div class="d-flex text-truncate">
				@if($count = $row->ratings()->count())
				<h5 class="mb-0 mr-2">x{{$count}}</h5>
				@endif
				@include('pages.ratings.stars', [
					'rating' => $row->score()
				])
			</div>
	</div>
</div>
  @endslot
@endresponsiveRow