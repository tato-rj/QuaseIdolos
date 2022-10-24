	<form onSubmit="return false;" class="row form-borderless mb-4 w-100">
		<div class="col-lg-5 col-md-8 col-10 mx-auto position-relative">
			<input data-url="{{route('cardapio.search')}}" type="text" name="search" autocomplete="off" placeholder="Procure por artista ou música" class="form-control">
			<div class="position-absolute px-2 h-100 d-center" style="right: 8px; top: 0;">@fa(['icon' => 'search', 'fa_color' => 'primary', 'fa_size' => 'lg'])</div>
		</div>
	</form>