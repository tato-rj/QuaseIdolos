<tr class="text-white table-row">
	@for($i=1;$i<=5;$i++)
	@isset(${'column'.$i})
	<td class="align-middle text-truncate p-3"><h6 class="m-0">{!!${'column'.$i}!!}</h6></td>
	@endisset
	@endfor

	@isset($actions)
	<td class="text-right align-middle p-3 text-truncate">{!!$actions!!}</td>
	@endisset
</tr>