<tr class="text-white table-row">
	@for($i=1;$i<=5;$i++)
	@isset(${'column'.$i})
	<td class="align-middle p-3 h6">{!!${'column'.$i}!!}</td>
	@endisset
	@endfor

	@isset($actions)
	<td class="text-right align-middle p-3 h6">{!!$actions!!}</td>
	@endisset
</tr>