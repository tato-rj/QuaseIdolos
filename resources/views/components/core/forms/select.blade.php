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
    <option selected disabled value="">{{$placeholder}}</option>
    @endisset

    {{$slot}}

  </select>
  
  @isset($info)
  <div class="form-text text-white text-left mt-2 fw-bold">@fa(['icon' => 'exclamation-circle']){{$info}}</div>
  @endisset

  @feedback(['input' => $name])
</div>