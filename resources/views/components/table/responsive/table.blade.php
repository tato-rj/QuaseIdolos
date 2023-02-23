<div class="results-container">
  <div class="table-container mb-0">
    
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