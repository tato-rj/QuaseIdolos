@extends('layouts.app', ['title' => 'Calendário'])

@push('header')
<style type="text/css">

</style>
@endpush

@section('content')
<section class="container mb-5">
	<div class="text-center">
		@pagetitle([
			'title' => 'A', 
			'subtitle' => 'Conheça quem toca com a gente',
			'highlight' => 'banda'])
	</div>
</section>

<section class="container mb-4">
	@include('pages.about.menu')
	<div class="row">
		<div class="col-lg-8 col-md-10 col-11 mx-auto">
			@include('pages.about.member')
		</div>
	</div>
</section>
@endsection

@push('scripts')
@endpush