<div id="cardapio-placeholder" style="display: none">
	<div class="row">
		<div class="col-lg-7 col-12" style="height: 400px;">
			<div class="bg-transparent placeholder-animate rounded p-3 h-100">
				@include('components.placeholders.block', ['height' => '30px', 'width' => '25%', 'classes' => 'mb-4'])
				@for($i=0;$i<10;$i++)
				@include('components.placeholders.block', ['height' => '22px', 'width' => rand(60, 90).'%', 'classes' => 'mb-2'])
				@endfor
			</div>
		</div>
		<div class="col-12 d-lg-none d-md-block py-3"></div>
		<div class="col-lg-5 col-12 d-flex flex-column" style="min-height: 360px;">
			<div class="mb-4">
				@include('components.placeholders.block', ['height' => '8px', 'width' => '100%'])
				@include('components.placeholders.block', ['height' => '40px', 'width' => '60%', 'classes' => 'mx-auto my-3'])
				@include('components.placeholders.block', ['height' => '8px', 'width' => '100%'])
			</div>
			
			<div class="d-flex flex-column justify-content-between" style="flex-grow: 1;">
				<div>
					@include('components.placeholders.block', ['height' => '30px', 'width' => '100%', 'classes' => 'mb-2'])
					@include('components.placeholders.block', ['height' => '30px', 'width' => '100%', 'classes' => 'mb-2'])
					@include('components.placeholders.block', ['height' => '30px', 'width' => '100%', 'classes' => 'mb-2'])
				</div>
				<div>
					@include('components.placeholders.block', ['height' => '30px', 'width' => '100%', 'classes' => 'mb-2'])
					@include('components.placeholders.block', ['height' => '30px', 'width' => '100%'])
				</div>
			</div>
		</div>
	</div>
</div>