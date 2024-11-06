<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .w-full {
            width: 100%
        }

        .table {
            border-collapse: collapse
        }

        .border {
            border: 1px solid
        }

        .border-black {
            border-color: black
        }

        .text-black {
            color: black
        }

        [dir="rtl"] .font-semibold {
            font-weight: 600;
        }

        .mt-0\.5 {
            margin-top: 0.125rem;
            /* 0.5 * 0.25rem */
        }

        .text-sm {
            font-size: 0.875rem;
            /* 14px */
            line-height: 1.25rem;
            /* 20px */
        }

        .max-w-28 {
            max-width: 7rem;
            /* 112px */
        }

        .truncate {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .text-slate-500 {
            --tw-text-opacity: 1;
            color: rgb(100 116 139 / var(--tw-text-opacity));
        }

        .font-medium {
            font-weight: 500
        }

        .px-2 {
            padding-left: .5rem;
            padding-right: .5rem
        }

        .px-3 {
            padding-left: .75rem;
            padding-right: .75rem
        }

        .py-1 {
            padding-top: .25rem;
            padding-bottom: .25rem
        }

        .py-0\.5 {
            padding-top: .125rem;
            padding-bottom: .125rem
        }

        .text-center {
            text-align: center
        }

        .whitespace-nowrap {
            white-space: nowrap
        }

        .mt-4 {
            margin-top: 1rem
        }

        .-mt-2 {
            margin-top: -0.5rem
                /* -8px */
            ;
        }

        .text-lg {
            font-size: 1.125rem
                /* 18px */
            ;
            line-height: 1.75rem
                /* 28px */
            ;
        }

        .flex {
            display: flex;
        }

        .justify-start {
            justify-content: flex-start;
        }

        .mx-auto {
            margin-left: auto;
            margin-right: auto;
        }

        .max-w-24 {
            max-width: 6rem
                /* 112px */
            ;
        }

        .max-h-20 {
            max-height: 5rem
                /* 112px */
            ;
        }

        .mb-2 {
            margin-bottom: 0.5rem
                /* 8px */
            ;
        }

        .rounded-md {
            border-radius: 0.375rem
                /* 6px */
            ;
        }

        .-mt-4 {
            margin-top: -1rem
                /* -8px */
            ;
        }

        .ms-68 {
            margin-inline-start: 17rem
                /* 64px */
            ;
        }
    </style>
</head>

<body>
    <div class="flex flex-col items-center justify-start mb-2">
        @if ($title != '')
            <div class="justify-start">
                @if (auth()->user()->tenant->getFirstMediaUrl('logos'))
                    <img src="{{ auth()->user()->tenant->getFirstMediaUrl('logos') }}" alt=""
                        class="max-w-24 mx-auto rounded-md">
                @else
                    <img src="{{ public_path('images/logo-black.svg') }}" alt=""
                        class="max-w-24 max-h-20 mx-auto rounded-md">
                @endif
            </div>
        @endif

        <div class="ms-68">
            <h2 class="font-medium rtl:font-semibold text-center">
                {{ auth()->user()->tenant['infos']['association'] }}
            </h2>

            <h2 class="text-lg font-medium rtl:font-semibold text-center -mt-4"> {{ $title }}
            </h2>
        </div>
    </div>

    <table class="w-full table border-black text-black">
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
