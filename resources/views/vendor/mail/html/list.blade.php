<div class="list-table border-secondary">
	@foreach($items as $key => $value)
	<div class="d-apart mb-1 px-3 py-2 lh-1" style="background: rgba(242,205,61,0.{{$loop->even ? '08' : '18'}})">
		<div class="{{! $loop->last ? 'mb-1' : null}}"><strong class="text-{{$theme}}">{{$key}}</strong></div>
		<div class="opacity-6">{{$value}}</div>
	</div>
	@endforeach
</div>