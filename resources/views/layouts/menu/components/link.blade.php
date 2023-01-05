<a class="nav-link bg-secondary rounded-pill px-4 py-1 mb-3" href="{{route($route)}}">
@isset($icon)
@fa(['icon' => 'trophy'])
@endisset
{{$label}}
@isset($count)
@if($count)
<small class="text-red no-stroke">({{$count}})</small>
@endif
@endisset
</a>