<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    {{ Vite::useBuildDirectory('build/dashboard') }}
    <style>
        {!! Vite::content('resources/css/app.css') !!}
    </style>
</head>

<body>
    <div class="flex relative items-center">
        @if ($title != '')
            <img src="{{ auth()->user()->tenant->getFirstMediaUrl('logos') ?: public_path('images/logo-black.svg') }}"
                alt="" class="max-w-24 max-h-20 rounded-md">
        @endif

        <div class="absolute left-1/2 transform -translate-x-1/2 mt-2">
            <h2 class="text-lg font-medium rtl:font-semibold text-center">
                {{ auth()->user()->tenant['infos']['association'] }}
            </h2>

            <h2 class="font-medium rtl:font-semibold text-center"> {{ $title }}
            </h2>
        </div>
    </div>

    <table class="w-full table border-collapse text-black mt-2 ">
        <thead>
            <tr>
                {{ $thead }}
            </tr>
        </thead>

        <tbody>
            {{ $tbody }}
        </tbody>
    </table>
</body>

</html>
