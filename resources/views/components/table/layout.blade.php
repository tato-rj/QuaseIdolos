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

  <div>
    <label class="mb-3">Total de {{$total}} @choice($legend, $total)</label>
  </div>
  
  <table class="table table-borderless table-container">
    @isset($headers)
    <thead>
      <tr class="text-white">
        @foreach($headers as $header)
        <th class="px-3 pb-2" scope="col">{{$header}}</th>
        @endforeach
      </tr>
    </thead>
    @endisset
    <tbody>
      @foreach($rows as $row)
        @include($view)
      @endforeach
    </tbody>
  </table>

  @if($hasPagination)
  {{ $rows->links() }}
  @endif
</div>
@endif