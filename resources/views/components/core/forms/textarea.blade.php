<div class="form-group">
	@isset($label)
    @label
    @endisset

	<textarea 
		class="form-control form-control-{{$size ?? null}} {{$classes ?? null}}" 
		name="{{$name}}" 
		rows="{{$rows ?? 4}}" 
		placeholder="{{$placeholder ?? null}}"
		@isset($id)id="{{$id}}"@endisset 
		{{iftrue($readonly ?? null, 'readonly')}} 
		{{iftrue($readonly ?? null, 'readonly')}}></textarea>
	
	@isset($info)
	<div class="form-text">{{$info}}</div>
	@endisset

	@feedback(['input' => $name])
</div>