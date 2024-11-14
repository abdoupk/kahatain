<!doctype html>
<html lang="en" class="default">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title> {{ config('app.name', 'Laravel') }} - {{ __('page_not_found') }}</title>

    <link rel="icon" href="/logo.png">
    {{ Vite::useBuildDirectory('build/dashboard') }}

    <style>
        {!! Vite::content('resources/css/app.css') !!}
    </style>
</head>

<body>
<div class="py-2 bg-gradient-to-b from-theme-1 to-theme-2 dark:from-darkmode-800 dark:to-darkmode-800">
    <div class="container">
        <!-- BEGIN: Error Page -->
        <div
            class="flex flex-col items-center justify-center h-screen text-center error-page lg:flex-row lg:text-left">
            <div class="-intro-x lg:mr-20">
                <img alt="" class="w-[450px] h-48 lg:h-auto"
                     src="{{ asset('images/error-illustration.svg') }}" />
            </div>
            <div class="mt-10 text-white lg:mt-0">
                <div class="font-medium intro-x text-8xl">404</div>
                <div class="mt-5 text-xl font-medium intro-x lg:text-3xl">
                    Oops. This page has gone missing.
                </div>
                <div class="mt-3 text-lg intro-x">
                    You may have mistyped the address or the page may have moved.
                </div>
                <Button
                    class="px-4 py-3 mt-10 text-white border-white intro-x dark:border-darkmode-400 dark:text-slate-200">
                    Back to Home
                </Button>
            </div>
        </div>
        <!-- END: Error Page -->
    </div>
</div>
</body>

</html>
