{{-- @php($allowChat = auth()->user()->liveGig && auth()->user()->participatesInChats() && auth()->user()->liveGig->participatesInChats()) --}}
{{-- @php($isChatPage = is_route('chat.index') || is_route('chat.between')) --}}
<div class="position-fixed d-flex align-items-center" style="bottom: 10px; right: 10px; z-index: 1;">
    {{-- CHAT --}}
    {{-- @if(! $isChatPage && $allowChat) --}}
    {{-- @include('pages.chat.badge') --}}
    {{-- @endif --}}
    
    @admin
    @include('pages.gigs.status')
    @endadmin
</div>

{{-- CHAT --}}
{{-- @if(! $isChatPage && $allowChat)
@include('pages.chat.modal')
@endif --}}