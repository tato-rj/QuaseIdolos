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

@case('venue.name')
{{$gig->venue->name}}
@break

  @case('setlist_count')
    {{$gig->setlist()->completed()->count()}}
  @break
@endswitch