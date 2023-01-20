<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{$title ?? 'Status'}} | {{config('app.name')}}</title>

        @include('layouts.components.favicon')

        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
        <link href="{{ mix('css/app.css') }}" rel="stylesheet">

        @stack('header')
    </head>
    <body class="p-5">
        
        @yield('content')
        
        <script src="{{ mix('js/app.js') }}"></script>
        
        @stack('scripts')
    </body>
</html>
