@foreach($user->socialAccounts as $socialAccount)
<h1>ASD</h1>
	<form method="POST" action="{{route('profile.unlink-social', $socialAccount)}}">
		@csrf
		<button type="submit" class="btn btn-{{$socialAccount->social_provider}} w-100 mb-2">@fa(['icon' => $socialAccount->social_provider, 'fa_type' => 'b'])Remover {{ucfirst($socialAccount->social_provider)}}</button>
	</form>
@endforeach