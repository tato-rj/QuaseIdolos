    <div class="text-white d-flex">
      @foreach($headers as $header)
      <div class="px-3 pb-2 col fw-bold text-truncate {{$loop->iteration > 2 && $header != '' ? 'd-none d-md-block' : null}}" style="{{$header == '' ? 'min-width: 180px' : null}}">{{$header}}</div>
      @endforeach
    </div>