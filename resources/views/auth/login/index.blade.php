@extends('layouts.app', ['title' => 'Login'])

@push('header')
@endpush

@section('content')
<section class="container">
	<div class="row">
		<div class="col-lg-4 col-md-6 col-11 mx-auto">
			@include('components.pagetitle', ['title' => 'Entrar'])
			@include('auth.login.form')
		</div>
	</div>
</section>
@endsection

@push('scripts')
@endpush