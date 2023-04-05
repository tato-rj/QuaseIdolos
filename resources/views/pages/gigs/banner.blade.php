@if($gig = auth()->user()->liveGig)
<div id="gig-banner" class="w-100 p-2 bg-{{$gig->sandbox() ? 'white' : 'secondary'}} text-center text-primary">
	<div class="d-center w-100">
		<h6 class="mb-0 mr-2 no-stroke">
			@if($gig->isShow())
			@fa(['icon' => 'child'])
			@endif
			@lang('models/gig.banner.text') {{$gig->name()}}
		</h6>

		@if(! subdomain() && \App\Models\Gig::ready()->count() > 1 && $gig->isKareoke())
		<a href="{{route('gig.select')}}" class="btn btn-sm btn-primary">@lang('models/gig.banner.btn')</a>
		@endif
	</div>
</div>

@guest
<div class="bg-white text-center fw-bold px-1 text-primary border-top boder border-primary">
	{!! $gig->feedback() !!}
</div>
@endguest
@endif