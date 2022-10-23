<form method="{{$method}}"
	@isset($data)
	@foreach($data as $type => $action)
	data-{{$type}}="{{$action}}"
	@endforeach
	@endisset
 	class="{{iftrue($borderless ?? null, 'form-borderless')}} {{iftrue($light ?? null, 'form-light')}} {{$classes ?? null}}" action="{{$url}}">
	@csrf
	@method($method)

	{{$slot}}	

</form>