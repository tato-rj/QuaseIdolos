<div class="form-group text-left">
	@isset($label)
    @label
    @endisset

	<textarea 
		class="form-control form-control-{{$size ?? null}} {{$classes ?? null}}" 
		name="{{$name}}" 
		rows="{{$rows ?? 4}}" 
		placeholder="{{$placeholder ?? null}}"
		@isset($id)id="{{$id}}"@endisset 
		{{iftrue($required ?? null, 'required')}}
		{{iftrue($readonly ?? null, 'readonly')}}>{{$value}}</textarea>
	
	@isset($info)
	<div class="form-text">{{$info}}</div>
	@endisset

	@feedback(['input' => $name])
</div>