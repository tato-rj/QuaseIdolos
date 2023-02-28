<div class="d-flex flex-column mx-auto mb-3" style="width: 300px;">
	@include('pages.setlists.admin.screens')

	@if(request()->formato == 'minimizado')
	<a href="{{url()->current()}}" class="btn btn-secondary mb-3">@fa(['icon' => 'window-maximize'])Formato normal</a>
	@else
	<a href="?formato=minimizado" class="btn btn-secondary mb-3">@fa(['icon' => 'compress'])Minimizar</a>
	@endif

	@if(request()->formato == 'metronomo')
	<a href="{{url()->current()}}" class="btn btn-secondary mb-3">@fa(['icon' => 'window-maximize'])Formato normal</a>
	@else
	<a href="?formato=metronomo" class="btn btn-secondary mb-3">@fa(['icon' => 'dot-circle'])Metrônomo</a>
	@endif

	<button id="refresh-table" class="btn btn-outline-secondary">@fa(['icon' => 'sync-alt'])Atualizar setlist</button>
</div>