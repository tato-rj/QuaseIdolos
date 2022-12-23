@php($gig = \App\Models\Gig::ready()->first())

@modal(['title' => $gig->name(), 'id' => 'select-gig-modal', 'autoshow' => true])

<h6 class="mb-3">Começamos o evento no {{$gig->name()}}, se tiver a senha pra participar é só escrever abaixo!</h6>
@include('pages.gigs.join.card', ['showPassword' => true])

@endmodal