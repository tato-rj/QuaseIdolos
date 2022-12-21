@php($status = $gig->status()->noText()->get())
<div class="position-fixed animate__animated animate__fadeInRight" style="bottom: 10px; right: 10px; ">
	<div class="status-icon-backdrop" style="font-size: 3.4rem">
		{!!$status!!}
	</div>
	<div class="position-absolute-center" style="font-size: 2.6rem">
		{!!$status!!}
	</div>
</div>