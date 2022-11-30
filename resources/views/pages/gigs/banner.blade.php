@if($gig = auth()->user()->liveGig())
<div id="gig-banner" class="w-100 p-2 bg-secondary text-center text-primary">
	<div class="d-center w-100">
		<h6 class="mb-0 mr-2 no-stroke">Estou no {{$gig->venue->name}}</h6>
		<a href="{{route('gig.select')}}" class="btn btn-sm btn-primary">Mudar</a>
	</div>
</div>
@endif