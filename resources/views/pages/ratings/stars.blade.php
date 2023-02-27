@php($rating = $rating ?? auth()->user()->ratingFor($songRequest))
<div class="d-flex justify-content-{{$position ?? null}}">
	@for($i=1;$i<=5;$i++)
	<button class="btn-raw star-rating {{$rating >= $i ? 'selected' : null}}" 
		@isset($editable)
		data-url="{{route('ratings.store', ['songRequest' => $songRequest, 'score' => $i])}}"
		@else
		style="cursor: default;" 
		@endisset
		>@fa(['icon' => 'star', 'fa_size' => $size ?? null, 'mr' => $i < 5 ? 2 : 0])</button>
	@endfor
</div>