@extends('layouts.app', ['title' => 'Setlist'])

@push('header')
<style type="text/css">

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
@endpush