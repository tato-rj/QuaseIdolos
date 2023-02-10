@php($gig = auth()->user()->liveGig)

@if($gig)
@php($status = $gig->status()->noText()->get())

<div class="d-flex align-items-center">
	@if($gig->password()->required() && auth()->user()->admin()->exists())
	<div class="rounded px-3 py-2 mr-2 animate__animated animate__fadeIn" style="background: rgba(0,0,0,0.5); margin-bottom: 4px;">
		<h4 class="mb-0 text-white">@fa(['icon' => 'key', 'classes' => 'opacity-6', 'fa_size' => 'sm', 'fa_color' => 'secondary']){{$gig->password}}</h4>
	</div>
	@endif
	<div class="animate__animated animate__fadeInRight">
		<div class="status-icon-backdrop" style="font-size: 3.4rem">
			{!!$status!!}
		</div>
		<div class="position-absolute-center" style="font-size: 2.6rem">
			{!!$status!!}
		</div>
	</div>
</div>
@endif