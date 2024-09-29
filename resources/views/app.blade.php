<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}"
    class="default">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ config('app.name', 'Laravel') }} </title>

    <link rel="icon" href="/logo.png">

    {{ Vite::useBuildDirectory('build/dashboard') }}

    <!-- Scripts -->
    @routes
    @vite(['resources/js/app.ts', "resources/js/Pages/{$page['component']}.vue"])
    @inertiaHead
</head>

<body class="!font-roboto antialiased overflow-x-hidden dark:bg-darkmode-700 scroll-smooth">
    @inertia
</body>

</html>
