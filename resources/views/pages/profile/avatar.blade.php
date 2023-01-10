<div class="position-relative" id="avatar-upload">
	<label for="upload" class="cursor-pointer rounded-circle d-center position-absolute-center opacity-8" style="width: 80px; height: 80px; z-index: 1; font-size: 1.6rem; background: rgba(0,0,0,0.2);">@fa(['icon' => 'camera', 'mr' => 0])
		<input type="file" name="avatar" id="upload" style="display: none">
	</label>
	@if(auth()->user()->hasAvatar())
	@include('components.avatar.image', ['size' => '60%', 'user' => auth()->user()])
	@else
	@include('components.avatar.initial', ['size' => '140px', 'fontsize' => '3rem', 'user' => auth()->user()])
	@endif
</div>
<label><small>A imagem tem que ser quadrada</small></label>