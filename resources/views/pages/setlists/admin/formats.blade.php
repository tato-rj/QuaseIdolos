<div class="d-flex mb-3">
	<a href="{{url()->current()}}" title="Formato normal" class="btn btn-{{! in_array(request()->formato, ['minimizado', 'metronomo']) ? 'secondary' : 'outline-secondary'}} w-100">@fa(['icon' => 'window-maximize', 'mr' => 0])</a>
	<a href="?formato=minimizado" title="Minimizado" class="btn btn-{{request()->formato == 'minimizado' ? 'secondary' : 'outline-secondary'}} mx-2 w-100">@fa(['icon' => 'compress', 'mr' => 0])</a>
	<a href="?formato=metronomo" title="Metrônomo" class="btn btn-{{request()->formato == 'metronomo' ? 'secondary' : 'outline-secondary'}} w-100">@fa(['icon' => 'dot-circle', 'mr' => 0])</a>
</div>