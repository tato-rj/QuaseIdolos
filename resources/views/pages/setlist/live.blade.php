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

<section class="container">
	<div class="row">
		@forelse($setlist as $request)
		@include('pages.setlist.components.request')
		@empty
		@include('pages.setlist.components.empty')
		@endforelse
	</div>
</section>

@endsection

@push('scripts')
@endpush