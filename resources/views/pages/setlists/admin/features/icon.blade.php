<div
	@if($hasFeature)
	@else
	class="opacity-4"
	@endif 
>
	@fa(['icon' => $icon, 'mr' => 0, 'classes' => 'mx-2', 'fa_size' => 'lg'])
</div>