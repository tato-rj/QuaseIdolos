<div class="form-group">
	@isset($label)
    @label
    @endisset

    <div class="form-control form-control-{{$size ?? null}} {{$classes ?? null}} d-flex">
    	<div>
    		@fa(['icon' => 'lock', 'fa_color' => 'grey-light'])	
    	</div>

		<input 
			class="border-0 w-100 h-100"
			type="password" 
			placeholder="••••••"
			autocomplete="off"
			maxlength="255" 
			name="{{$name}}"
			
			@if(old($name))
			value="{{old($name)}}"
			@else
			value="{{$value ?? null}}"
			@endif

			@isset($id)id="{{$id}}"@endisset
			{{iftrue($readonly ?? null, 'readonly')}}>

		<button class="btn-raw toggle-password text-primary btn-sm" data-target="[name={{$name}}]">
			Show
		</button>
	</div>
	
	@isset($info)
	<div class="form-text">{{$info}}</div>
	@endisset

	@feedback(['input' => $name])
</div>