<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{$title ?? 'Welcome'}} | {{config('app.name')}}</title>

        @include('layouts.components.favicon')
        @include('layouts.components.seo')

        <link href="{{ mix('css/app.css') }}" rel="stylesheet">

        <style type="text/css">
h1, h2, h3, h4, h5, label, .nav-link, .btn, button {
    font-family: 'Fredoka One', cursive;
}
h1, h2, h3, h4 {
    -webkit-text-stroke: 2px black;
}
.nav-link, .btn, button, h5, label {
    -webkit-text-stroke: 1px black;
}

.no-stroke {
    -webkit-text-stroke: 0 !important;
}

.offcanvas.offcanvas-end {
    width: auto;
    min-width: 300px;
}
      @keyframes blinking {
        0% {
          opacity: 0.7;
        }
        50% {
          opacity: 1;
        }
        100% {
          opacity: .7;
        }
      }

      .blink {
        animation: blinking 1s infinite;
      }
        </style>
        @stack('header')
    </head>
    <body class="bg-primary" data-user="{{auth()->check() ? auth()->user() : null}}">
        @include('layouts.header')

        <div id="page-content">
            <div class="pt-3 pb-5">
                @yield('content')
            </div>
        </div>

        @include('layouts.footer')

        @include('layouts.components.alerts')

        <script src="{{ mix('js/app.js') }}"></script>
        @stack('scripts')
    </body>
</html>
