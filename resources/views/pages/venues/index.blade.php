@extends('layouts.app', ['title' => 'Contratantes'])

@push('header')
<style type="text/css">

</style>
@endpush

@section('content')
<section class="container-fluid">
	<div class="text-center mb-4">
		@pagetitle(['title' => 'Gerencie aqui os', 'highlight' => 'contratantes'])
		@create(['name' => 'venue', 'label' => 'Novo contratante', 'folder' => 'venues'])
	</div>
</section>

<section class="container mb-4">
	<div class="row">
		@forelse($venues as $venue)
		@include('pages.venues.card')
		@empty
		@include('components.empty')
		@endforelse
	</div>
</section>
@endsection

@push('scripts')
<script type="text/javascript">
</script>
@endpush