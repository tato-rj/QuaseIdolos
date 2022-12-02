@php($gig = auth()->user()->liveGig())
@modal(['title' => 'Bem vindo(a)!', 'id' => 'gig-welcome-modal', 'autoshow' => true])
<div class="text-center mb-4">
	<h4>Você está participando do</h4>
	<h2 class="mb-4">{{$gig->name()}}</h2>
</div>

<div class="border border-secondary border-4 rounded py-3 px-2">
	<h6 class="text-secondary text-center">REGRAS DO JOGO</h6>
	<div class="px-3">
		@foreach($gig->rules() as $rule)
		@if($rule)
		<div class="d-flex align-items-center mb-2">
			<div class="mr-2">
				<h6 class="bg-secondary d-center rounded-circle mb-0" style="width: 32px; height: 32px">{{$loop->iteration}}</h6>
			</div>
			<h6 class="mb-0">{{$rule}}</h6>
		</div>
		@endif
		@endforeach
	</div>
</div>
@endmodal