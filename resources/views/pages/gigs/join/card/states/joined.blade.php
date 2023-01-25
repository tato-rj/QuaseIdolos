<div class="join-card px-4 pt-4 pb-3">
	<div class="position-relative mb-4">
		<p class="mb-1">@fa(['icon' => 'check', 'fa_color' => 'green'])Você está participando do</p>
		<h3 class="no-stroke mb-4">{{$gig->name()}}</h3>
		
		@if($description = $gig->description())
		<h6 class="opacity-8">{{$description}}</h6>
		@endif
	</div>
	@divider
</div>

