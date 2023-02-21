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
  @if($gig->password()->required())
  <span class="ml-1 opacity-6 text-white rounded-pill bg-transparent px-2 py-1">@fa(['icon' => 'key', 'fa_size' => 'xs', 'fa_color' => 'secondary']){{$gig->password}}</span>
  @endif
  @endslot
@endrow
