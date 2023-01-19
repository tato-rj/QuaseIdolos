<div class="form-group">
    @isset($label)
    <h6 class="mb-3">{{$label}}</h6>
    @endisset

    <div>
        @isset($options)
        @foreach($options as $value => $label)
        <div class="form-check {{iftrue($inline ?? null, 'form-check-inline')}} {{$classes ?? null}}">
          <input 
            class="form-check-input" 
            name="{{$name}}[]" 
            type="checkbox" 
            value="{{$value}}" 
            id="checkbox-{{$value}}" 
            {{ is_array(old($name)) && in_array($value, old($name)) ? ' checked' : '' }}
            {{iftrue($readonly ?? null, 'readonly')}}>
                <label class="form-check-label" for="checkbox-{{$value}}">{{$label}}</label>
        </div>
        @endforeach
        @else
        {{$slot}}
        @endisset
    </div>

    @isset($info)
    <div class="form-text">{{$info}}</div>
    @endisset

    @feedback(['input' => $name])
</div>