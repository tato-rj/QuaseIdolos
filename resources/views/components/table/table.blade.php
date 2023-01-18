<div class="results-container">
  <div class="table-container mb-{{$mb ?? 0}}">
    @isset($headers)
    @include('components.table.headers')
    @endisset

    <div>
      @foreach($rows as $row)
        @include($view)
      @endforeach
    </div>

  </div>

  @if($hasPagination)
  {{ $rows->appends(array_filter(request()->all()))->links() }}
  @endif
</div>