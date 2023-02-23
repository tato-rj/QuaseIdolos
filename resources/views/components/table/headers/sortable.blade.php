@php($selected = request()->sort_by == table()->getFieldname($field))

@form(['method' => 'GET', 'url' => url()->full(), 'csrf' => false])
<input type="hidden" name="sort_by" value="{{table()->getFieldname($field)}}">
<input type="hidden" name="order" value="{{$selected && request()->order == 'asc' ? 'desc' : 'asc'}}">
<button type="submit" class="d-apart btn-raw w-100
  @if(request()->has('sort_by'))
  @unless($selected && request()->sort_by == table()->getFieldname($field))
  opacity-4
  @endunless
  @endif
"> 
  {{$label}}
  @fa(['icon' => $selected && request()->order == 'asc' ? 'chevron-up' : 'chevron-down', 'mr' => 0])
</button>
@endform
