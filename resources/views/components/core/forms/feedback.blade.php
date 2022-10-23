<div class="valid-feedback">
  Looks good!
</div>

<div class="invalid-feedback {{$errors->has($input) ? 'd-block' : null}}">
  @error($input)
  @fa(['icon' => 'exclamation-circle', 'fa_color' => 'red', 'mr' => 1]){{$message}}
  @enderror
</div>