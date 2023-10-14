@php($user = $entry->user)

<div style="margin-left: -18px" class="mb-1">
	@if($user->hasAvatar())
	@include('components.avatar.image', ['size' => '46px', 'classes' => 'border border-1'])
	@else
	@include('components.avatar.initial', ['size' => '46px', 'classes' => 'border border-1'])
	@endif
</div>