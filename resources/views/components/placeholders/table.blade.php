<div>
	@foreach([1,2,3,4,5] as $row)
	<div class="p-4 {{$loop->odd ? 'bg-transparent' : null}} placeholder-animate opacity-6 d-flex align-items-center">
		<div class="rounded-circle mr-3" style="width: 40px; height: 40px; background: rgba(0,0,0,0.15);"></div>
		<div class="rounded mr-2" style="width: 180px; height: 40px; background: rgba(0,0,0,0.15);"></div>
	</div>
	@endforeach
</div>