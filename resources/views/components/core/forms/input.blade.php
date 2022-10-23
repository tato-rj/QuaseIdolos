<div class="form-group">
	@isset($label)
    @label
    @endisset

    <div class="form-control form-control-{{$size ?? null}} d-flex {{$classes ?? null}}">
    	<div>
    		@isset($icon)
    		@fa(['icon' => $icon, 'fa_color' => 'grey-light'])	
    		@endisset
    	</div>
	<input
		class="border-0 w-100 h-100"
		type="{{$type ?? 'text'}}" 
		@isset($mask) data-mask="{{$mask}}"@endisset 
		placeholder="{{$placeholder ?? null}}" 
		name="{{$name}}"
		
		@if(old($name))
		value="{{old($name)}}"
		@else
		value="{{$value ?? null}}"
		@endif

		@isset($id)id="{{$id}}"@endisset
		{{iftrue($readonly ?? null, 'readonly')}}>
	</div>
	
	@isset($info)
	<div class="form-text">{{$info}}</div>
	@endisset

	@feedback(['input' => $name])
</div>