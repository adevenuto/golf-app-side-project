<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('partials/head')
    <body>
        <div id="app" class="d-flex flex-column">
            <navigation-component></navigation-component>
            <div class="my-4">
                @yield('content')
            </div>
        </div>
        @include('partials/scripts')
    </body>
</html>
