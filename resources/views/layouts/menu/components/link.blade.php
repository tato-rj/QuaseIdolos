<a class="nav-link bg-secondary rounded-pill px-4 py-1 mb-3" href="{{$route}}">
@isset($icon)
@fa(['icon' => 'trophy'])
@endisset

{{$label ?? null}}

@isset($lang)
@lang($lang)
@endisset

@isset($count)
@if($count)
<small class="text-red no-stroke">({{$count}})</small>
@endif
@endisset
</a>