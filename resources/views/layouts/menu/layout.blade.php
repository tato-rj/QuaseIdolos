@if(auth()->user()->hasAvatar())
@include('components.avatar.image', ['offcanvas' => true, 'user' => auth()->user()])
@else
@include('components.avatar.initial', ['offcanvas' => true, 'user' => auth()->user()])
@endif

@if(auth()->user()->isAdmin())
@include('layouts.menu.admin')
@else
@include('layouts.menu.user')
@endif