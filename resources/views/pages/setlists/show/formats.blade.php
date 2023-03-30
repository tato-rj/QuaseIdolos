<div class="d-flex mb-3">
	<a href="{{url()->current()}}" title="Formato normal" class="btn btn-{{! in_array(request()->formato, ['metronomo']) ? 'secondary' : 'outline-secondary'}} w-100 mr-2">@fa(['icon' => 'compress', 'mr' => 0])</a>
	<a href="?formato=metronomo" title="Metrônomo" class="btn btn-{{request()->formato == 'metronomo' ? 'secondary' : 'outline-secondary'}} w-100">@fa(['icon' => 'dot-circle', 'mr' => 0])</a>
</div>