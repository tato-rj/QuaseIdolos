<div class="join-password" style="display: none" id="gig-{{$gig->id}}-password-container">
	<h5 class="text-center no-stroke text-dark mb-3">SENHA DO EVENTO</h5>
	<div class="row password-digits">
		<input id="gig-{{$gig->id}}-password" data-real="{{$gig->password}}" type="hidden">
		@foreach($gig->password()->digits() as $digit)
		@include('pages.gigs.join.card.digit')
		@endforeach

		<form method="POST" action="{{route('gig.join', $gig)}}">
			@csrf
			@method('PATCH')
			<input type="hidden" name="password" value="{{$gig->password}}">
		</form>
	</div>
</div>