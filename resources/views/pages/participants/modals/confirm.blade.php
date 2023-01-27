@modal(['title' => 'Alguém te convidou!', 'id' => 'confirm-invitate', 'autoshow' => true])
@php($invitations = auth()->user()->invitations()->unconfirmed()->get())

<div class="mb-3">
	<img class="w-100" src="{{$invitations->first()->giphy()}}">
</div>

<div class="mb-3">
	<h4 class="text-center mb-3">Você tem <span class="text-secondary border-bottom border-secondary">{{$invitations->count()}} @choice('convite|convites', $invitations->count())</span> pra cantar!</h4>
	@divider
</div>

@foreach($invitations as $invitation)
	@php($user = $invitation->songRequest->user)
	@php($song = $invitation->songRequest->song)
	<div class="{{! $loop->last ? 'mb-4' : null}}">
		@include('pages.participants.modals.invitation')	
	</div>

	@unless($loop->last)
	@divider
	@endunless
@endforeach

@endmodal