@modal(['title' => 'Usuário','id' => 'user-info-modal-'.$user->id, 'data' => ['url' => route('users.info', $user)]])
<div id="user-info-content"></div>
{{-- <div id="recommendation-placeholder">
	<div class="row justify-content-center">
		@include('components.placeholders.recommendation')
	</div>
</div> --}}
@endmodal