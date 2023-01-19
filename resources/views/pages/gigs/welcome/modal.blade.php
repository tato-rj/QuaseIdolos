@php($gig = auth()->user()->liveGig)
@modal(['title' => 'Bem vindo(a)!', 'id' => 'gig-welcome-modal', 'autoshow' => true])
<div class="text-center mb-4">
	<h4>Você está participando do</h4>
	<h2>{{$gig->name()}}</h2>
	
	@if($gig->musicians()->exists())
	<h6 class="m-0">BANDA</h6>
	<h6 class="text-secondary">{{arrayToSentence($gig->musicians->pluck('admin.user.first_name')->toArray())}}</h6>
	@endif
</div>

<div class="border border-secondary border-4 rounded py-3 px-2">
	<h6 class="text-secondary text-center">REGRAS DO JOGO</h6>
	<div class="px-3">
		<div class="rounded bg-white p-3 mb-3 text-center">
			@foreach($gig->rules($global = true) as $rule)
			@include('pages.gigs.welcome.global')
			@endforeach
		</div>
		
		@php($rulecount = 1)
		@foreach($gig->rules() as $rule)
		@if($rule)
		@include('pages.gigs.welcome.rule')
		@php($rulecount += 1)
		@endif
		@endforeach
	</div>
</div>
@endmodal