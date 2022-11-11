@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => config('app.url')])
<a href="{{route('home')}}">
  <img src="{{asset('images/brand/logo_sm.svg')}}" alt="" width="100">
</a>
@endcomponent
@endslot

{{-- Body --}}
{{ $slot }}

{{-- Subcopy --}}
@isset($subcopy)
@slot('subcopy')
@component('mail::subcopy')
{{ $subcopy }}
@endcomponent
@endslot
@endisset

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
<div class="d-center mb-2" style="opacity: .4">
    <a href="{{config('social.facebook')}}" target="_blank" class="mx-2"><img src="{{asset('images/icons/facebook.svg')}}" alt="" width="32"></a>
    <a href="{{config('social.instagram')}}" target="_blank" class="mx-2"><img src="{{asset('images/icons/instagram.svg')}}" alt="" width="32"></a>
</div>

© {{ date('Y') }} {{ config('app.name') }}. @lang('All rights reserved.')
@endcomponent
@endslot
@endcomponent
