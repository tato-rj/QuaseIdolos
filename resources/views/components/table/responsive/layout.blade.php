@php($hasPagination = hasPagination($rows))
@php($total = $hasPagination ? $rows->total() : $rows->count())

@if($rows->isEmpty())

  @isset($empty)

  @isset($title)
  <h4 class="">@fa(['icon' => 'list-ul']){{$title}}</h4> 
  @endisset
  
  @include('components.empty')
  @endisset

@else

<div class="mb-5">
  @isset($title)
  <h4 class="">@fa(['icon' => 'list-ul']){{$title}}</h4> 
  @endisset

  @isset($legend)
  <div>
    <label class="mb-3">@lang('views/table.total') {{$total}} @choice($legend, $total)</label>
  </div>
  @endisset
  
  @include('components.table.responsive.table')
</div>
@endif