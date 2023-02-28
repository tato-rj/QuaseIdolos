<div class="valid-feedback">
  Looks good!
</div>

@isset($errors)
<div class="invalid-feedback text-secondary {{$errors->has($input) ? 'd-block' : null}}">
  @error($input)
  @fa(['icon' => 'exclamation-circle', 'fa_color' => 'secondary', 'mr' => 1]){{$message}}
  @enderror
</div>
@endisset