@extends('layouts.app', ['title' => 'Usuários'])

@push('header')
<style type="text/css">

</style>
@endpush

@section('content')
<section class="container ">
	<div class="text-center mb-4">
		@pagetitle(['title' => 'Gerencie aqui os', 'highlight' => 'usuários'])

		@searchbar([
			'name' => 'search_user',
			'placeholder' => 'Procure por usuário',
			'url' => route('users.search')])

		@create(['name' => 'user', 'label' => 'Novo usuário', 'folder' => 'users'])
		
		<a href="{{route('users.emails')}}" class="btn btn-secondary m-1 btn-lg">@fa(['icon' => 'envelope'])Lista de emails</a>
	</div>

	<div id="users-container">
		@include('pages.users.results')
	</div>
	<div id="results-container">
		
	</div>
</section>


@endsection

@push('scripts')
<script type="text/javascript">
$('button.update-gender').on('click', function() {
	let $button = $(this);
	let gender = $(this).data('gender');
	let $buttons = $button.parent().children();

	$button.disable();

	axios.patch($(this).data('url'), {gender: gender})
		 .then(function(response) {
			$buttons.addClass('hover-opacity-7').find('i').addClass('opacity-4');
			$button.removeClass('hover-opacity-7').find('i').removeClass('opacity-4');

			$buttons.enable();
			$button.disable();
		 })
		 .catch(function(error) {
		 	$button.enable();
		 });
});
</script>

<script type="text/javascript">
$('input[name="search_user"]').keyup(function() {
	let input = $(this).val();

	if (input.length > 0 && input.length < 3)
		return;

	axios.get($(this).data('url'), { params: { input: input } })
		 .then(function(response) {
		 	if (response.data) {
			 	$('#users-container').hide();
			 	$('#results-container').html(response.data).show();
			 } else {
			 	$('#users-container').show();
			 	$('#results-container').html(response.data).hide();
			 }
		 })
		 .catch(function(error) {
			alert('Try again...');
		});

});
</script>
@endpush