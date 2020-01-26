<head>
    <meta charset="utf-8">

    {{-- temp --}}
    <meta name="robots" content="noindex">
    <meta name="googlebot" content="noindex">
    {{-- temp --}}
    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- CSRF Token -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken'=> csrf_token()
        ]) !!};
    </script>
</head>