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
			'subtitle' => auth()->user()->liveGig ? 'Esse evento está com ' . $users->count() . ' ' . plural('participante', $users->count()) : 'Não tem nenhum evento acontecendo agora'])
	</div>
</section>

<section class="container">
	<div class="col-lg-8 col-md-10 col-12 mx-auto">
		@if(auth()->user()->liveGig)
		@include('pages.chat.components.users', ['noHeadline' => true])
		@else
		@include('components.empty')
		@endif
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