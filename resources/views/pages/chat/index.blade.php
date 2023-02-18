@extends('layouts.app', ['title' => 'Chat'])

@push('header')
<style type="text/css">

</style>
@endpush

@section('content')
<section class="container mb-5">
	<div class="text-center">
		@pagetitle([
			'title' => 'Chat',
			'subtitle' => 'Esse evento está com ' . $users->count() . ' ' . plural('participante', $users->count())])
	</div>
</section>

<section class="container">
	<div class="col-lg-8 col-md-10 col-12 mx-auto">
		@include('pages.chat.components.users', ['noHeadline' => true])
	</div>
</section>
@endsection

@push('scripts')
<script type="text/javascript">
$('.chat-user-btn').on('click', function() {
	window.location.href = $(this).data('url');
});
</script>
@endpush