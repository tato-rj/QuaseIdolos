<div class="song-result" 
@if($loop->odd)
style="background: rgba(0,0,0,0.08);"
@endif
>
	<div class="d-flex mx-auto py-3 align-items-center" style="max-width: {{isset($fullwidth) ? null : '900px'}}; width: 95%">
		<div class="w-100">
			<h4 class="m-0">{{$name}}</h4>
			@isset($artist)
			<h6 class="m-0">{{$artist}}</h6>
			@endisset
		</div>
		<div class="d-flex">
			{{$action}}
		</div>
	</div>
</div>