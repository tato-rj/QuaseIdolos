<form onSubmit="return false;" class="row form-borderless mb-4 mx-0">
	<div class="col-lg-5 col-md-8 col-10 mx-auto d-flex">
		<div class="position-relative mr-2 w-100 align-items-center">
			<input data-url="{{route('cardapio.search')}}" type="text" name="search" autocomplete="off" placeholder="Procure por artista ou música" class="form-control">
			<div class="position-absolute px-2 h-100 d-center" style="right: 8px; top: 0;">@fa(['icon' => 'search', 'fa_color' => 'primary', 'fa_size' => 'lg'])</div>
		</div>
		<button class="btn-raw text-primary-dark rounded-circle d-center no-stroke" style="width: 44.8px; height: 44.8px; background: rgba(255,255,255,0.2); font-size: 1.2rem;">@fa(['icon' => 'sliders-h', 'mr' => 0])</button>
	</div>
</form>