@php($status = $gig->status($withText = false))
<div class="position-fixed animate__animated animate__fadeInRight" style="bottom: 10px; right: 10px; ">
	<div class="opacity-2" style="font-size: 3rem">
		{!!$status!!}
	</div>
	<div class="position-absolute-center" style="font-size: 2.2rem">
		{!!$status!!}
	</div>
</div>