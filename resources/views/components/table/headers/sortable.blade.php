@php($selected = request()->sort_by == $field)
<div class="px-3 pb-2 col fw-bold text-truncate {{in_array($loop->iteration, $optional ?? []) ? 'd-none d-md-block' : null}}" 
  style="min-width: {{$header == '' ? '180px' : null}}">
  <form method="GET" action="{{url()->full()}}">
    <input type="hidden" name="sort_by" value="{{$field}}">
    <input type="hidden" name="order" value="{{$selected && request()->order == 'asc' ? 'desc' : 'asc'}}">
    <button class="d-apart btn-raw text-white no-stroke fw-bold w-100" style="font-family: 'Nunito';">
      <div>{{$header}}</div>
      <div class="{{$selected ? null : 'opacity-4'}}">@fa(['icon' => $selected && request()->order == 'asc' ? 'chevron-down' : 'chevron-up', 'mr' => 0])</div>
    </button>
  </form>
</div>