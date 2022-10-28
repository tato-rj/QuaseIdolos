@extends('layouts.app', ['title' => 'Setlist'])

@push('header')
<style type="text/css">
.drag__target {
	border: 4px dashed;
}
</style>
@endpush

@section('content')
<section class="container">
	<div class="text-center mb-4">
		<h2>SETLIST DE <span class="text-secondary">HOJE</span></h2>
	</div>
</section>

<section class="container" id="setlist-container">
	@include('pages.setlist.components.table')
</section>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/jquery-sortablejs@latest/jquery-sortable.js"></script>
<script type="text/javascript">
	
</script>
<script type="text/javascript">
// var $draggedElement = $();
// var $target = $();

// $('[draggable]').on('dragstart', function(e) {
// 	$draggedElement = $(e.currentTarget);
// 	log('Start');
// });

// $('[draggable]').on('dragend', function(e) {
// 	log('End');
// });

// $('[draggable]').on('dragenter', function(e) {
// 	if ($(e.currentTarget).is($draggedElement) || $target.length)
// 		return;

// 	$target = $(e.currentTarget);
// 	log('Enter');
// });

// $('[draggable]').on('dragleave', function(e) {
// 	if ($(e.currentTarget).is($draggedElement) || $(e.relatedTarget).parents('[draggable]').length)
// 		return;

// 	$target = $();
// 	log('Leave');
// });
</script>
@endpush