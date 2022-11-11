@modal(['title' => 'Bem vindo(a)!', 'id' => 'gig-welcome-modal', 'autoshow' => true])
<div class="text-center">
	<h4>Você está participando do</h4>
	<h2 class="mb-4">{{auth()->user()->liveGig()->name}}</h2>

	@if(auth()->user()->isAdmin())
	<a href="{{route('setlists.admin')}}" class="btn btn-secondary w-100 btn-lg mb-3">@fa(['icon' => 'users'])SETLIST DE HOJE</a>
	@else
	<a href="{{route('cardapio.index')}}" class="btn btn-secondary w-100 btn-lg mb-3">NOSSO CARDÁPIO</a>
	@endif
    <a class="btn btn-secondary w-100 btn-lg" href="{{route('ratings.index')}}">@fa(['icon' => 'trophy'])Votação</a>
</div>
@endmodal