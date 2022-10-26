<div class="col-12 pt-{{$pt ?? 5}} text-center opacity-4">
	@fa(['icon' => 'box-open', 'mr' => 0, 'fa_size' => '6x', 'classes' => 'mb-2'])
	@isset($message)
	<h5 class="no-stroke text-white m-0">{{$message}}</h5>
	@endisset
</div>