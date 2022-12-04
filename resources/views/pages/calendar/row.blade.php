@php($gig = $row)

@row
  @slot('column1')
  <div class="d-flex flex-wrap"> 
		<div class="mr-2">{{$gig->name()}}</div>
		<div class="text-secondary">{{$gig->dateInContext}}</div>
	</div>
  @endslot

  @slot('column2')

  @endslot

  @slot('actions')

		<button data-bs-toggle="modal" data-bs-target="#info-gig-{{$gig->id}}-modal" class="btn btn-secondary btn-sm text-nowrap">@fa(['icon' => 'info-circle'])Mais detalhes</button>
{{-- 
		@include('pages.calendar.info')
		 --}}
  @endslot
@endrow