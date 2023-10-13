@php($user = $entry->user)

<div style="margin-left: -18px">
	@if($user->hasAvatar())
	@include('components.avatar.image', ['size' => '56px', 'classes' => 'border border-2'])
	@else
	@include('components.avatar.initial', ['size' => '56px', 'classes' => 'border border-2'])
	@endif
</div>