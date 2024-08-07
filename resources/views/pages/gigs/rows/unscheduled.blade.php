

@php($gig = $row)
@switch(str_replace('*', '', $field))
  @case('event')
		<div class="d-flex align-items-center">
			<form method="POST" action="{{route('gig.duplicate', $gig)}}">
				@csrf
				<button class="btn-raw">@fa(['icon' => 'copy', 'fa_color' => 'white'])</button>
			</form>
			<div class="opacity-8">{{$gig->name()}}</div>
		</div>
      @break

  @case('actions')
			<button data-bs-toggle="modal" data-bs-target="#edit-gig-{{$gig->id}}-modal" class="btn btn-sm btn-secondary text-truncate mr-2">@fa(['icon' => 'pencil-alt', 'mr' => 0])</button>

			<form method="POST" action="{{route('gig.destroy', $gig)}}" class="d-inline">
				@csrf
				@method('DELETE')
				<button class="btn btn-sm btn-outline-secondary">@fa(['icon' => 'trash-alt', 'mr' => 0])</button>
			</form>

			@include('pages.gigs.modals.edit')
			@include('pages.gigs.modals.delete')
      @break
@endswitch

@php($gig = $row)