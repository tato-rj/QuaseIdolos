<div class="mb-3">
	<h2 class="mb-0 text-center text-uppercase px-2">
		{{$title}} <span class="text-secondary">{{$highlight ?? null}}</span>
	</h2>
	@isset($subtitle)
	<h5 class="m-0">{{$subtitle}}</h5>
	@endisset
</div>