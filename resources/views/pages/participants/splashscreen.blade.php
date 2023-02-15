<div class="position-fixed bg-primary top-0 left-0 w-100 h-100vh" style="z-index: 10000000;" id="participant-video-confirmed-container">
	<div class="h-100 w-100 d-center">
		<video style="width: 100%; transition: 1s;" id="participant-video-confirmed" muted="muted" data-target="#participant-video-confirmed-container">
			{{-- @if($agent->isMobile()) --}}
			  <source src="{{asset('videos/invitation_splash_vertical.mp4')}}" type="video/mp4" />
			{{-- @else --}}
			  {{-- <source src="{{asset('videos/invitation_splash_horizontal.mp4')}}" type="video/mp4" /> --}}
			{{-- @endif --}}
		</video>
	</div>
</div>