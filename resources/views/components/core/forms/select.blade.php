<div class="form-group">
  @isset($label)
  @label
  @endisset

  <select 
    class="form-select form-select-{{$size ?? null}} {{$classes ?? null}}" 
    name="{{$name}}" 
    @isset($id)id="{{$id}}"@endisset 
    {{iftrue($required ?? null, 'required')}}
    {{iftrue($readonly ?? null, 'readonly')}}>
    
    @isset($placeholder)
    <option selected value="">{{$placeholder}}</option>
    @endisset

    {{$slot}}

  </select>
  
  @isset($info)
  <div class="form-text">{{$info}}</div>
  @endisset

  @feedback(['input' => $name])
</div>