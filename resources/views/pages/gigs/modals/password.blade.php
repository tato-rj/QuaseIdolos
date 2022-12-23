@php($gig = \App\Models\Gig::ready()->first())

@modal(['title' => $gig->name(), 'id' => 'select-gig-modal', 'autoshow' => true])

<p>Começamos o evento no {{$gig->name()}}, se tiver a senha pra participar é só escrever abaixo!</p>
@include('pages.gigs.join.card', ['showPassword' => true])

@endmodal