<div class="d-flex align-items-center">
	<input readonly type="text" name="from" class="cursor-pointer rounded border-0 form-control datepicker" autocomplete="off" size="10" style="font-size: .875rem; line-height: 1.5" value="{{$firstDate->format('d/m/Y')}}">
	<h6 class="mb-0 mx-2">até</h6>
	<input readonly type="text" name="to" class="cursor-pointer rounded border-0 form-control datepicker" autocomplete="off" size="10" style="font-size: .875rem; line-height: 1.5" value="{{$lastDate->format('d/m/Y')}}">
</div>
