@extends('layouts.app', ['title' => 'Chat com '])

@push('header')
<style type="text/css">

</style>
@endpush

@section('content')
<button id="get-chat" style="display: none;" data-url="{{route('chat.between', ['userOne' => auth()->user(), 'userTwo' => $user])}}" data-from-id="{{$user->id}}"></button>

<section class="container mb-5">
	<div class="row">
		<div class="col-lg-6 col-md-8 col-12 mx-auto">
			@include('pages.chat.components.user')
		</div>
	</div>
</section>
@endsection

@push('scripts')
<script type="text/javascript">
$(document).ready(function() {
	chat.getUser('#get-chat');
});
</script>
@endpush