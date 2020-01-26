<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('partials/head')
    <body class="font-nunito">
        <div id="app">
            <navigation-component user='{{ Auth::user() }}'></navigation-component>
            <div class="my-5">
                @yield('content')
            </div>
        </div>
        @stack('scripts')
        @include('partials/scripts')
    </body>
</html>
