<div class="d-flex flex-column mx-auto mb-3" style="width: 300px;">
	@include('pages.setlists.admin.screens')

	@if(request()->has('compact'))
	<a href="{{url()->current()}}" class="btn btn-secondary mb-3">@fa(['icon' => 'window-maximize'])Formato normal</a>
	@else
	<a href="?compact" class="btn btn-secondary mb-3">@fa(['icon' => 'compress'])Minimizar</a>
	@endif

	<button id="refresh-table" class="btn btn-outline-secondary">@fa(['icon' => 'sync-alt'])Atualizar setlist</button>
</div>