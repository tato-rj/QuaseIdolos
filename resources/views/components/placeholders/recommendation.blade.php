@for($i=0;$i<10;$i++)
<div class="text-center col-lg-3 col-md-4 col-6 mb-3">
	<div class="rounded bg-transparent placeholder-animate p-3 h-100 border-secondary">
		<div class="rounded-circle mb-4 bg-transparent mx-auto" style="width: 100px; height: 100px"></div>
		@include('components.placeholders.block', ['height' => '20px', 'width' => '100%', 'classes' => 'mb-1'])
		@include('components.placeholders.block', ['height' => '20px', 'width' => '100%', 'classes' => 'mb-4'])
		<div class="mt-4">
			@include('components.placeholders.block', ['height' => '20px', 'width' => '100%', 'classes' => 'mb-1'])
			@include('components.placeholders.block', ['height' => '20px', 'width' => '100%'])
		</div>
	</div>
</div>
@endfor