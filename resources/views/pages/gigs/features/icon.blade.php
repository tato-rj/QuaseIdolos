<div
	@if($hasFeature)
	class="no-stroke"
	@else
	class="opacity-4 no-stroke"
	@endif 
>
	@fa(['icon' => $icon, 'mr' => 0, 'classes' => 'mx-2', 'fa_size' => $size])
</div>