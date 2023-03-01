<button data-bs-toggle="modal" data-bs-target="#screens-modal" class="btn btn-secondary mb-3 w-100">@fa(['icon' => 'share-alt'])Opções</button>

@modal(['title' => 'Opções','id' => 'screens-modal', 'size' => 'sm'])

<a href="" data-bs-toggle="modal" data-bs-target="#edit-gig-{{$gig->id}}-modal" class="btn btn-secondary mb-2 w-100">@fa(['icon' => 'clipboard-list'])Editar evento</a>

@include('pages.gigs.modals.edit', ['pausable' => true])

@include('layouts.menu.components.divider')

@include('pages.setlists.admin.options.password')
@include('pages.setlists.admin.options.lyrics')
@include('pages.setlists.admin.options.ratings')

@endmodal