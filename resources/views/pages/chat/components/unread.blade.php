@php($unreadCount = $count ?? auth()->user()->receivedMessages()->unread()->count())

@if($unreadCount)
<div class="position-absolute bg-red text-white d-center fw-bold rounded-circle" 
	style="width: 20px; height: 20px; font-size: 80%; top: 8px; right: 8px; z-index: 1">{{$unreadCount}}</div>
@endif