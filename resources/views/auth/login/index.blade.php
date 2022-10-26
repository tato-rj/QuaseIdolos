@extends('layouts.app', ['title' => 'Login'])

@push('header')
@endpush

@section('content')
<section class="container">
	<div class="row">
		<div class="col-lg-4 col-md-6 col-10 mx-auto">
			<h1>Login</h1>
			@include('auth.login.form')
		</div>
	</div>
</section>
@endsection

@push('scripts')
@endpush