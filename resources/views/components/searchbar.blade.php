<div class="row">
	<div class="{{$sizes ?? 'col-lg-5 col-md-8 col-12'}} mx-auto d-flex">
		<form onSubmit="return false;" class="form-borderless mb-4 mx-0 w-100">
				<div class="position-relative w-100 align-items-center">
					<input data-url="{{$url ?? null}}" data-target="#{{$target ?? null}}" data-paginate="{{$paginate ?? null}}" data-table="{{$table ?? null}}" value="{{request()->input}}" type="text" name="{{$name ?? 'search'}}" autocomplete="off" placeholder="{{$placeholder}}" class="form-control">
					<div class="position-absolute px-2 h-100 d-center" style="right: 0; top: 0;">@fa(['icon' => 'search', 'fa_color' => 'primary'])</div>
				</div>
				{{-- <button class="btn-raw text-primary-dark rounded-circle d-center no-stroke" style="width: 44.8px; height: 44.8px; background: rgba(255,255,255,0.2);">@fa(['icon' => 'sliders-h', 'mr' => 0])</button> --}}
		</form>
	</div>
</div>