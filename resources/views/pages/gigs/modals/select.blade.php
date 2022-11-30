@php($gigsReady = \App\Models\Gig::ready()->get())
@modal(['title' => 'Escolha o evento', 'id' => 'select-gig-modal', 'autoshow' => true])
@foreach($gigsReady as $gig)
@include('pages.gigs.join.card')
@endforeach
@endmodal