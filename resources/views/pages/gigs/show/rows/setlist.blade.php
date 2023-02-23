@php($song = $row->song)

@responsiveRow
  @slot('column1')
  <div>
  	<div class="cursor-pointer" id="row-{{$row->id}}" data-bs-toggle="collapse" data-bs-target="#collapse-{{$row->id}}">
		  <div>
				{{$song->name}}
			</div>
			<div class="text-secondary">
				{{$song->artist->name}}
			</div>
		</div>

    <div id="collapse-{{$row->id}}" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#setlist-accordion">
      <div class="mt-3">
        <p class="opacity-6 m-0">Cantada por</p>
        <h6 class="m-0">{{$row->user->name}}</h6>
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