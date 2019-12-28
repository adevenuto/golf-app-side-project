<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('partials/head')
    <body>
        <div id="app">
            <navigation-component user='{{ Auth::user() }}'></navigation-component>
            <div class="my-4">
                @yield('content')
            </div>
        </div>
        @stack('scripts')
        @include('partials/scripts')
    </body>
</html>
