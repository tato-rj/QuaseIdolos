@php($hasPagination = hasPagination($rows))
@php($total = $hasPagination ? $rows->total() : $rows->count())
@php($header = $header ?? true)

@if($rows->isEmpty())

  @isset($empty)

  @isset($title)
  <h5 class="mb-3">@fa(['icon' => 'list-ul']){{$title}}</h5> 
  @endisset
  
  @include('components.empty')
  @endisset

@else

<div class="{{$margin ?? 'mb-5'}}">
  @isset($title)
  <h5 class="{{! isset($legend) ? 'mb-3' : null}}">@fa(['icon' => 'list-ul']){{$title}}</h5> 
  @endisset

  @isset($legend)
  <div>
    <label class="mb-3">@lang('views/table.total') {{$total}} @choice($legend, $total)</label>
  </div>
  @endisset
  

    @include('components.table.table')

</div>
@endif