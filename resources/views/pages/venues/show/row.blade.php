@php($gig = $row)

@row(['optional' => $optional ?? []])
  @slot('column1')
		<div class="d-flex align-items-center">
			<form method="POST" action="{{route('gig.duplicate', $gig)}}">
				@csrf
				<button class="btn-raw">@fa(['icon' => 'copy', 'fa_color' => 'white'])</button>
			</form>
			<a href="{{route('gig.show', $gig)}}" class="link-secondary fw-bold d-block h5 mb-0">{{$gig->dateForHumans($showWeek = false)}}</a>
		</div>
  @endslot

  @slot('column2')
  {{$gig->participants()->count()}}
  @endslot

  @slot('column3')
  {{$gig->setlist()->completed()->count()}}
  @endslot

  @slot('column4')
  {!! $gig->status() !!}
  @endslot

  @slot('actions')
    @if($gig->isOver())
      <a href="#" class="btn btn-sm btn-secondary text-truncate">Mais detalhes</a>
    @else
      <button data-bs-toggle="modal" data-bs-target="#edit-gig-{{$gig->id}}-modal" class="btn btn-sm btn-secondary text-truncate mr-2">@fa(['icon' => 'pencil-alt', 'mr' => 0])</button>
      <button data-bs-toggle="modal" data-bs-target="#delete-gig-{{$gig->id}}-modal" class="btn btn-sm btn-outline-secondary text-truncate">@fa(['icon' => 'trash-alt', 'mr' => 0])</button>

      @include('pages.gigs.modals.edit')
      @include('pages.gigs.modals.delete')
    @endif
  @endslot
@endrow