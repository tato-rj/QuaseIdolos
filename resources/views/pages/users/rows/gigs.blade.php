@php($gig = $row->gig)

@row
  @slot('column1')
  {{$gig->name()}}
  @endslot

  @slot('column2')
  {{$gig->dateForHumans()}}
  @endslot
@endrow
