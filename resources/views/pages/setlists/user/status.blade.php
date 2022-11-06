@if(! $list->finished_at)
	@php($count = $song->setlistPosition())
	@if($count == 0)
	<span class="text-green text-center mb-2">@fa(['icon' => 'microphone'])Está na hora!</span>
	@else
	<span class="text-secondary text-center mb-2">@fa(['icon' => 'hourglass-half'])@choice('Falta|Faltam', $count) {{$count}}</span>
	@endif
@else
	<span class="opacity-6 text-center mb-2 text-truncate d-md-none">{{$list->finished_at->format('d/m')}}</span>

	<span class="opacity-6 text-center mb-2 text-truncate d-none d-md-block">Cantada no dia {{$list->finished_at->format('d/m')}}</span>
@endif