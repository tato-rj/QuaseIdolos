<div class="position-fixed d-flex align-items-center" style="bottom: 10px; right: 10px; z-index: 1;">
    {{-- CHAT --}}
    @local
    @if(auth()->user()->liveGig)
    @include('components.chat.badge')
    @endif
    @endlocal
    
    @admin
    @include('pages.gigs.status')
    @endadmin
</div>

{{-- CHAT --}}
@local
@if(auth()->user()->liveGig)
@include('components.chat.modal')
@endif
@endlocal