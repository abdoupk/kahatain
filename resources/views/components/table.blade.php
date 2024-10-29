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
    </style>
</head>

<body>
    <h2 class="font-medium rtl:font-semibold text-center">
        {{ auth()->user()->tenant['infos']['association'] }}
    </h2>

    <h2 class="text-lg font-medium rtl:font-semibold text-center -mt-2"> {{ $title }}
    </h2>

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
