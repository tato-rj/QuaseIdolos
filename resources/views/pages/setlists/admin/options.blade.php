<div class="mb-3 w-100">
	@include('pages.setlists.admin.options.modal')

	@if($gig->isKareoke() && $gig->sets()->current()->exists())
	<form method="POST" action="{{route('setlists.set.reset')}}" data-trigger="loader">
		@csrf
		<button type="submit" class="btn btn-outline-secondary w-100">@fa(['icon' => 'sync-alt'])Resetar o set</button>
	</form>
	@endif
</div>