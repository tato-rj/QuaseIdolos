@php($gig = $row)
@switch(str_replace('*', '', $field))
  @case('scheduled_for')
    <div class="d-flex align-items-center">
      <form method="POST" action="{{route('gig.duplicate', $gig)}}">
        @csrf
        <button class="btn-raw">@fa(['icon' => 'copy', 'fa_color' => 'white'])</button>
      </form>
      <a href="{{route('gig.show', $gig)}}" class="link-secondary fw-bold d-block h5 mb-0">{{$gig->dateForHumans($showWeek = false)}}</a>
    </div>
      @break

  @case('participants_count')
    {{$gig->participants()->count()}}
      @break

  @case('song_requests_count')
    {{$gig->setlist()->completed()->count()}}
    @break

  @case('status')
    {!! $gig->status()->get() !!}
    @break
@endswitch