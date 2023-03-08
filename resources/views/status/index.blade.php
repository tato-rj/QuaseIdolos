@extends('layouts.status')

@push('header')
@endpush

@section('content')
<section class="container">
	<div class="row">
		<div class="col-lg-6 col-md-10 col-12 mx-auto">
			<h6 class="mb-4 fw-bold">DATABASE</h6>

			<div class="accordion" id="status-container">
				@foreach($report as $model => $errors)
					@include('status.components.model')
				@endforeach
			</div>
		</div>
	</div>
</section>
@endsection

@push('scripts')
@endpush