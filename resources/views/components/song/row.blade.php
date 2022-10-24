<div class="song-result" 
@if($loop->odd)
style="background: rgba(0,0,0,0.08);"
@endif
>
	<div class="d-flex mx-auto py-3 align-items-center" style="max-width: {{isset($fullwidth) ? null : '900px'}}; width: 95%">
		<div class="row w-100">
			@isset($artist)
			<div class="col-lg-6 col-md-6 col-12 d-flex align-items-center">
				{{$name}}
			</div>
			<div class="col-lg-6 col-md-6 col-12 d-flex align-items-center">
				{{$artist}}
			</div>
			@else
			<div class="col-12 d-flex align-items-center">
				{{$name}}
			</div>
			@endisset
		</div>
		<div class="d-flex">
			{{$action}}
		</div>
	</div>
</div>