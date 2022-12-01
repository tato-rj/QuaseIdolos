@php($gig = $row)

@row
  @slot('column1')
		<div class="d-flex align-items-center">
			<form method="POST" action="{{route('gig.duplicate', $gig)}}">
				@csrf
				<button class="btn-raw">@fa(['icon' => 'copy', 'fa_color' => 'white'])</button>
			</form>
			<div class="opacity-8">Sem data</div>
		</div>
  @endslot

  @slot('actions')
		<button data-bs-toggle="modal" data-bs-target="#edit-gig-{{$gig->id}}-modal" class="btn btn-sm btn-secondary text-truncate mr-2">@fa(['icon' => 'pencil-alt', 'mr' => 0])</button>
		<button data-bs-toggle="modal" data-bs-target="#delete-gig-{{$gig->id}}-modal" class="btn btn-sm btn-outline-secondary text-truncate">@fa(['icon' => 'trash-alt', 'mr' => 0])</button>

		@include('pages.gigs.modals.edit')
		@include('pages.gigs.modals.delete')
  @endslot
@endrow