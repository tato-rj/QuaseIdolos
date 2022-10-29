@extends('layouts.app', ['title' => 'Setlist'])

@push('header')
<style type="text/css">
.dragged {
	opacity: 0.2;
}
</style>
@endpush

@section('content')
<section class="container">
	<div class="text-center mb-4">
		<h2>SETLIST DE <span class="text-secondary">HOJE</span></h2>
		@if($gig)
		<p class="no-stroke text-secondary fw-bold" style="font-size: 1.5rem">{{$gig->name}}</p>
		@else
		<h5>Não tem nenhum evento marcado pra hoje</h5>
		@endif
	</div>
</section>

<section class="container" id="setlist-container">
	@include('pages.song-requests.components.table')
</section>

@endsection

@push('scripts')
<script type="text/javascript">
enableDraggable();
</script>
@endpush