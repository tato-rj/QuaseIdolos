<div class="song-result" 
@if($loop->odd)
style="background: rgba(0,0,0,0.08);"
@endif
>
	<div class="d-flex mx-auto py-3 align-items-center" style="max-width: {{isset($fullwidth) ? null : '900px'}}; width: 95%">
		<div class="w-100">
			<div style="font-size: 1.2rem">{{$name}}</div>
			@isset($artist)
			<div>{{$artist}}</div>
			@endisset
		</div>
		<div class="d-flex">
			{{$action}}
		</div>
	</div>
</div>