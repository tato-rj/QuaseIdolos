@modal(['title' => 'Tem certeza?','id' => 'remove-social-'.$socialAccount->id.'-modal'])
<form method="POST" action="{{route('profile.unlink-social', $socialAccount)}}">
	@csrf
		<p class="">Quer desautorizar o login com <u>{{ucfirst($socialAccount->social_provider)}}</u>?</p>

	@submit(['label' => 'Sim, pode continuar', 'theme' => 'secondary'])
</form>
@endmodal