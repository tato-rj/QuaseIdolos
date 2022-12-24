@extends('layouts.app', ['title' => 'Senha', 'raw' => true])

@push('header')
@endpush

@section('content')
<div class="h-100vh w-100 d-center">
	<div class="text-center">
		<h3 class="text-secondary">A senha desse evento é</h3>
		<h1 style="font-size: 12rem; letter-spacing: 18px">{{$gig->password}}</h1>
	</div>
</div>
@endsection

@push('scripts')
@endpush