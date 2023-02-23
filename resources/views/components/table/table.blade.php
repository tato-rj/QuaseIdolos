<div class="results-container">

    <table class="table w-auto table-borderless table-striped text-nowrap table-hover">
      @if($header)
      <thead>
        <tr>
          @foreach($columns as $field => $label)
          <th scope="col" class="text-white px-3">{{$label}}</th>
          @endforeach
        </tr>
      </thead>
      @endif
      <tbody>
        @foreach($rows as $row)
        <tr>
          @foreach($columns as $field => $label)
            <td class="{{$field == 'actions' ? 'text-right' : null}} align-middle px-3 py-3">
              @if($field == 'actions')
              @include($view)
              @else
              <h6 class="m-0 text-white">@include($view)</h6>
              @endif
            </td>
          @endforeach
        </tr>
        @endforeach
      </tbody>
    </table>


  @if($hasPagination)
  {{ $rows->appends(array_filter(request()->all()))->links() }}
  @endif
</div>

{{-- <div class="results-container">
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


</div> --}}