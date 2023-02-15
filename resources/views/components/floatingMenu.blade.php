<div class="position-fixed d-flex align-items-center" style="bottom: 10px; right: 10px; z-index: 1;">
    {{-- CHAT --}}
    {{-- @admin --}}
    @if(auth()->user()->liveGig)
    @include('components.chat.badge')
    @endif
    {{-- @endadmin --}}
    
    @admin
    @include('pages.gigs.status')
    @endadmin
</div>

{{-- CHAT --}}
{{-- @admin --}}
@if(auth()->user()->liveGig)
@include('components.chat.modal')
@endif
{{-- @endadmin --}}