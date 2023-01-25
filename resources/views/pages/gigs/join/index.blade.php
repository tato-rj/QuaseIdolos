@extends('layouts.app', ['title' => 'Evento'])

@push('header')
<style type="text/css">

</style>
@endpush

@section('content')
<section class="container-fluid">
	@if($gigs->where('joined', 1)->isEmpty())
	<div class="text-center mb-4">
		@pagetitle([
			'title' => 'Onde você',
			'highlight' => 'está?',
			'subtitle' => $gigs->isEmpty() ? 'Nenhum show marcado pra hoje' : 'Nós temos mais de um show acontendo hoje, por favor escolha abaixo em qual você está participando'])
	</div>
	@endif
	<div class="row">
		<div class="col-lg-6 col-md-8 col-12 mx-auto">
			@forelse($gigs as $gig)
			@include('pages.gigs.join.card')
			@empty
			@include('components.empty')
			@endforelse
		</div>
	</div>
</section>
@endsection

@push('scripts')
<script type="text/javascript">

</script>
@endpush