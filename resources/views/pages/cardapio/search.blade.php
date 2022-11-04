<form onSubmit="return false;" class="row form-borderless mb-4 mx-0">
	<div class="col-lg-5 col-md-8 col-11 mx-auto d-flex">
		<div class="position-relative w-100 align-items-center">
			<input data-url="{{route('cardapio.search')}}" value="{{request()->input}}" type="text" name="search" autocomplete="off" placeholder="Procure por artista ou música" class="form-control">
			<div class="position-absolute px-2 h-100 d-center" style="right: 0; top: 0;">@fa(['icon' => 'search', 'fa_color' => 'primary'])</div>
		</div>
		{{-- <button class="btn-raw text-primary-dark rounded-circle d-center no-stroke" style="width: 44.8px; height: 44.8px; background: rgba(255,255,255,0.2);">@fa(['icon' => 'sliders-h', 'mr' => 0])</button> --}}
	</div>
</form>