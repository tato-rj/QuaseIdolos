@php($hasPagination = hasPagination($rows))
@php($total = $hasPagination ? $rows->total() : $rows->count())

@if($rows->isEmpty())

  @isset($empty)
  @include('components.empty')
  @endisset

@else

<div class="mb-5">
  @isset($title)
  <h4 class="">@fa(['icon' => 'list-ul']){{$title}}</h4> 
  @endisset

  @isset($legend)
  <div>
    <label class="mb-3">Total de {{$total}} @choice($legend, $total)</label>
  </div>
  @endisset
  
  @include('components.table.table')
</div>
@endif