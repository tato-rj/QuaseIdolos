@php($gig = $row->gig)

@row
  @slot('column1')
  {{$gig->dateForHumans()}}
  @endslot

  @slot('column2')
  <a href="{{route('gig.show', $gig)}}" class="link-secondary">{{$gig->name()}}</a>
  @endslot
@endrow
