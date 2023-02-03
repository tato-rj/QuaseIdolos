@if($gig = auth()->user()->liveGig)
<div id="gig-banner" class="w-100 p-2 bg-{{$gig->sandbox() ? 'white' : 'secondary'}} text-center text-primary">
	<div class="d-center w-100">
		<h6 class="mb-0 mr-2 no-stroke">@lang('models/gig.banner.text') {{$gig->name()}}</h6>
		@if(\App\Models\Gig::ready()->count() > 1)
		<a href="{{route('gig.select')}}" class="btn btn-sm btn-primary">@lang('models/gig.banner.btn')</a>
		@endif
	</div>
</div>
@endif