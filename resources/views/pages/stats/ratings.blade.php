<div class="border border-secondary rounded text-center position-relative mx-auto" style="max-width: 360px; border-width: 8px !important;">
	<div class="bg-secondary rounded-circle d-center position-absolute x-auto stroke-light" 
		style="width: 90px; height: 90px; top: -70px; font-size: 1.8rem">
		@fa(['icon' => 'trophy', 'mr' => 0])
	</div>
	<h3 class="mt-1 text-secondary pt-4 px-4 pb-2">Top 5</h3>
	@foreach($topUsers as $user)
	<div class="d-apart py-2 px-4"
	@if($loop->odd)
	style="background: rgba(0,0,0,0.08);"
	@endif
	>
		<div class="d-flex align-items-center">
			<div class="mr-2" style="width: 36px">
				@if($user->hasAvatar())
				@include('components.avatar.image')
				@else
				@include('components.avatar.initial')
				@endif
			</div>
			<h5 class="m-0">{{$user->first_name}}</h5>
		</div>
		<h4 class="m-0 text-secondary">{{(int) $user->ratings_avg_score}}</h4>
	</div>
	@endforeach
</div>