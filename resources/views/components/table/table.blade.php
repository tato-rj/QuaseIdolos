<div class="results-container">
  <div class="table-container mb-0">
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

{{-- <div class="results-container">
  <table class="table table-borderless table-container mb-0">
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
  {{ $rows->appends(array_filter(request()->all()))->links() }}
  @endif
</div> --}}