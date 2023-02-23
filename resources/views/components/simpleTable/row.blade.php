@php($columns = collect())
@for($i=1;$i<=5;$i++)
@isset(${'column'.$i})
@php($columns->push('column'.$i))
@endisset
@endfor

<div class="text-white striped-row d-flex align-items-center">

	@foreach($columns as $column)
	<div class="align-middle p-3 text-truncate {{in_array($loop->iteration, $optional ?? []) ? 'd-none d-md-block' : null}} {{$columns->count() == 1 ? 'flex-grow-1' : 'col'}}">
		<h6 class="m-0 table-cell">{!!${$column}!!}</h6>
	</div>
	@endforeach

	@isset($actions)
	<div class="col text-right align-middle p-3">
		<div class="text-truncate">
			{!!$actions!!}
		</div>
	</div>
	@endisset

</div>
