@php($gig = \App\Models\Gig::ready()->first())

@modal(['title' => $gig->name(), 'id' => 'select-gig-modal', 'autoshow' => true])

@include('pages.gigs.join.card', ['showPassword' => true])

@endmodal