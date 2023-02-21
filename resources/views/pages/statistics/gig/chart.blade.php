<div class="p-2">
	<div  class="border p-4 border-secondary border-5 rounded chart-container" data-target="#{{$id}}" data-model="{{$model}}" data-column="{{$column}}">
		<h4 class="mb-3">{{$title}}</h4>
		<div class="d-apart mb-4">
			@include('pages.statistics.components.duration')
			@include('pages.statistics.components.dates')
		</div>

		<canvas id="{{$id}}"></canvas>
	</div>
</div>