@php($list = $row)
@php($song = $list->song)

@row
  @slot('column1')
  <div class="d-flex align-items-center">
		@include('pages.cardapio.results.row.name')
	</div>
  @endslot

  @slot('actions')
  @endslot
@endrow