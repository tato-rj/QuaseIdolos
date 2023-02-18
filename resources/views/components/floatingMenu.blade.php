<div class="position-fixed d-flex align-items-center" style="bottom: 10px; right: 10px; z-index: 1;">
    {{-- CHAT --}}
    @if(auth()->user()->liveGig && auth()->user()->participatesInChats() && auth()->user()->liveGig->participatesInChats())
    @include('components.chat.badge')
    @endif
    
    @admin
    @include('pages.gigs.status')
    @endadmin
</div>

{{-- CHAT --}}
@if(auth()->user()->liveGig && auth()->user()->participatesInChats() && auth()->user()->liveGig->participatesInChats())
@include('components.chat.modal')
@endif