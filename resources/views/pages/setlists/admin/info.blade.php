@modal(['title' => 'Ficha Técnica', 'id' => 'gig-'.$gig->id.'-modal'])
@include('pages.gigs.status', ['pauseOnly' => true])

<div class="text-left">
	<div class="mb-2">
		<label class="text-secondary">Evento</label>
		<h3>{{$gig->venue->name}}</h3>
	</div>

	@if($gig->starts_at)
	<div class="mb-2">
		<label class="text-secondary">Começou às</label>
		<h3>{{$gig->starts_at->format('G:i')}}</h3>
	</div>
	@endif

	<div class="mb-2">
		<label class="text-secondary">Limite de músicas</label>
		<h3>{{$gig->songs_limit ?? 'Sem limite'}}</h3>
	</div>

	<div class="mb-4">
		<label class="text-secondary">Limite por pessoa</label>
		<h3>{{$gig->songs_limit_per_user ?? 'Sem limite'}}</h3>
	</div>

	<a href="{{route('gig.edit', $gig)}}" class="btn btn-secondary w-100">Mais detalhes</a>
</div>
@endmodal