@modal(['title' => 'Mais detalhes', 'id' => 'info-gig-'.$gig->id.'-modal'])

<div class="text-center">
	<h2>{{$gig->name()}}</h2>
	<p class="opacity-8">{{$gig->description()}}</p>
	<h4 class="text-secondary">{{$gig->dateForHumans}}</h4>
	<h3>{{$gig->starting_time}}</h3>
</div>

@endmodal