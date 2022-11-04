@extends('layouts.app', ['title' => 'Cantores'])

@push('header')
<style type="text/css">

</style>
@endpush

@section('content')
<section class="container ">
	<div class="text-center mb-4">
		<h2 class="mb-3">GERENCIE AQUI OS <span class="text-secondary">CANTORES</span></h2>
		@include('pages.users.search')
	</div>

	<div id="results-container">
		<h5 class=" ml-5">Total de {{$users->count()}} @choice('cantor|cantores', $users->count())</h5>
		<div class="d-flex justify-content-center flex-wrap"> 
			@foreach($users as $user)
			<a href="{{route('users.edit', $user)}}" class="link-none">
				@include('pages.users.avatar', ['size' => '100px', 'fontsize' => '2rem', 'namesize' => '1.2rem'])
			</a>
			@endforeach
		</div>
	</div>
</section>


@endsection

@push('scripts')
<script type="text/javascript">
$('input[name="search"]').keyup(function() {
	let input = $(this).val();

	if (input.length > 0 && input.length < 3)
		return;

	axios.get($(this).data('url'), { params: { input: input } })
		 .then(function(response) {
		 	$('#results-container').html(response.data);
		 })
		 .catch(function(error) {
			alert('Try again...');
		});

});
</script>
@endpush