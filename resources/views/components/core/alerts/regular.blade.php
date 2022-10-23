<div class="alert-container alert-{{$style ?? 'regular'}} rounded-0  {{$classes ?? null}} @isset($pos)alert-{{$pos}}@endisset"@isset($countdown)data-countdown="{{$countdown}}"@endisset @isset($attr){{$attr}}@endisset>
	<div class="alert @isset($animation)animate__animated animate__{{$animation['in']}}@endisset rounded m-0 alert-{{$color}} alert-dismissible {{$classes ?? null}}" role="alert">
		@isset($headline)<strong class="mr-2"> {!! $headline !!} |</strong>@endisset{!! $message !!}
	<button type="button" class="btn-close text-{{$color}}" data-dismiss="alert"@isset($animation){{' data-animation=animate__'.$animation['out']}}@endisset aria-label="Close"></button>
</div>  
</div>