@foreach($user->socialAccounts as $socialAccount)
	<button data-bs-toggle="modal" data-bs-target="#remove-social-{{$socialAccount->id}}-modal" class="btn btn-{{$socialAccount->social_provider}} text-truncate mb-2">@fa(['icon' => $socialAccount->social_provider, 'fa_type' => 'b'])@lang('views/auth.social-remove') {{ucfirst($socialAccount->social_provider)}}</button>
	
	@include('pages.users.modals.removeSocial')

@endforeach