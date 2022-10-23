<h5 data-id="{{$id ?? null}}" data-step="{{$step}}" data-option="{{$option ?? null}}" class="border-secondary rounded bg-primary z-10">{{$text ?? null}}{{$slot ?? null}}</h5>
@unless(isset($bar) && ! $bar)
<span style="display: {{isset($id) ? 'none' : null}}" data-step="{{$step}}" data-option="{{$option ?? null}}" class="bar-vertical bg-secondary"></span>
@endunless