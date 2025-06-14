@php
    $config = [
        'appName' => config('app.name'),
        'locale' => $locale = app()->getLocale(),
        'locales' => config('app.locales'),
    ];
@endphp
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SQL Check</title>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <!--<link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">-->
    <script>
        window.config = @json($config);
    </script>
    <!-- Scripts -->
{{--    @vite(['resources/sass/app.scss', 'resources/js/app.js'])--}}
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])

</head>
<body class="font-sans antialiased" id="app">
    <router-view></router-view>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBwoXNHQAsvDqvdG3qJ0-MGYieC85E8T8E"></script>
</body>
</html>
