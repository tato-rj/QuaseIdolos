@php($gig = $row->gig)

@row
  @slot('column1')
  {{$gig->dateForHumans()}}
  @endslot

  @slot('column2')
  @admin
  <a href="{{route('gig.show', $gig)}}" class="link-secondary">{{$gig->name()}}</a>
  @else
  <span class="text-secondary">{{$gig->name()}}</span>
  @endadmin
  @endslot
@endrow
