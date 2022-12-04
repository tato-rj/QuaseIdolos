@modal(['title' => $gig->name(), 'id' => 'info-gig-'.$gig->id.'-modal'])

<div class="text-center">
	<h2 class="mb-4">{{$gig->name()}}</h2>
	<p>{{$gig->description}}</p>
</div>

<h3 class="m-0">Quando?</h3>
{{-- <h3 class="m-0">{{$gig->scheduled_for->}}</h3> --}}
@endmodal