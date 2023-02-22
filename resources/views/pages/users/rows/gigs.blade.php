@php($gig = $row->gig)

@switch(str_replace('*', '', $field))
  @case('scheduled_for')
    {{$gig->dateForHumans()}}
      @break

  @case('name')
      @admin
      <a href="{{route('gig.show', $gig)}}" class="link-secondary">{{$gig->name()}}</a>
      @else
      <span class="text-secondary">{{$gig->name()}}</span>
      @endadmin
      @if($gig->password()->required())
      <span class="ml-1 opacity-6 text-white rounded-pill bg-transparent px-2 py-1">@fa(['icon' => 'key', 'fa_size' => 'xs', 'fa_color' => 'secondary']){{$gig->password}}</span>
      @endif
      @break
@endswitch