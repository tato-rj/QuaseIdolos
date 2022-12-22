<div class="col">
	<input data-target="#gig-{{$gig->id}}-password"
	name="digit" 
	id="gig-{{$gig->id}}-digit-{{$loop->iteration}}"
	@if(! $loop->last)
	data-next="#gig-{{$gig->id}}-digit-{{$loop->iteration + 1}}"
	@endif
	 inputmode="numeric" pattern="[0-9]*" type="text" maxlength="1" data-value="{{$digit}}" class="text-center h2 border-0 bg-transparent p-2 rounded w-100 h-100 t-2">
</div>