<div class="d-apart">
  <div class="mr-2 fw-bold">
    {{$label ?? null}}
  </div>
  <label class="switch">
    <input name="{{$name}}" type="checkbox" {{$on ? 'checked' : null}}>
    <span class="slider round"></span>
  </label>
</div>