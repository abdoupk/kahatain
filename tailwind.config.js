import containerQueries from '@tailwindcss/container-queries'
import forms from '@tailwindcss/forms'
import typography from '@tailwindcss/typography'
import colors from 'tailwindcss/colors'
import { parseColor } from 'tailwindcss/lib/util/color'
import plugin from 'tailwindcss/plugin'

const toRGB = (value) => {
    return parseColor(value).color.join(' ')
}

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/**/*.{js,jsx,ts,tsx,vue}'
    ],

    safelist: [
        {
            pattern: /animate-delay-.+/
        }
    ],

    darkMode: 'class',

    theme: {
        extend: {
            aria: {
                asc: 'sort="ascending"',
                desc: 'sort="descending"',
                none: 'sort="none"',
                other: 'sort="other"'
            },
            colors: {
                theme: {
                    1: 'rgb(var(--color-theme-1) / <alpha-value>)',
                    2: 'rgb(var(--color-theme-2) / <alpha-value>)'
                },
                primary: 'rgb(var(--color-primary) / <alpha-value>)',
                secondary: 'rgb(var(--color-secondary) / <alpha-value>)',
                success: 'rgb(var(--color-success) / <alpha-value>)',
                info: 'rgb(var(--color-info) / <alpha-value>)',
                warning: 'rgb(var(--color-warning) / <alpha-value>)',
                pending: 'rgb(var(--color-pending) / <alpha-value>)',
                danger: 'rgb(var(--color-danger) / <alpha-value>)',
                light: 'rgb(var(--color-light) / <alpha-value>)',
                dark: 'rgb(var(--color-dark) / <alpha-value>)',
                darkmode: {
                    50: 'rgb(var(--color-darkmode-50) / <alpha-value>)',
                    100: 'rgb(var(--color-darkmode-100) / <alpha-value>)',
                    200: 'rgb(var(--color-darkmode-200) / <alpha-value>)',
                    300: 'rgb(var(--color-darkmode-300) / <alpha-value>)',
                    400: 'rgb(var(--color-darkmode-400) / <alpha-value>)',
                    500: 'rgb(var(--color-darkmode-500) / <alpha-value>)',
                    600: 'rgb(var(--color-darkmode-600) / <alpha-value>)',
                    700: 'rgb(var(--color-darkmode-700) / <alpha-value>)',
                    800: 'rgb(var(--color-darkmode-800) / <alpha-value>)',
                    900: 'rgb(var(--color-darkmode-900) / <alpha-value>)'
                }
            },
            fontFamily: {
                roboto: ['"Roboto"'],
                'public-sans': ['"Public Sans"'],
                'google-sans': ['"Product Sans"'],
                athelas: ['"Athelas Arabic"'],
                noto: ['"Noto Sans Arabic"']
            },
            container: {
                center: true
            },
            maxWidth: {
                '1/4': '25%',
                '1/2': '50%',
                '3/4': '75%'
            },
            strokeWidth: {
                0.5: 0.5,
                1.5: 1.5,
                2.5: 2.5
            },
            backgroundImage: {
                'bredcrumb-chevron-ltr-dark':
                    "url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='1' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='9 18 15 12 9 6'%3E%3C/polyline%3E%3C/svg%3E\")",
                'bredcrumb-chevron-rtl-dark':
                    "url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='none' stroke='currentColor' stroke-linecap='round' stroke-linejoin='round' stroke-width='1'%3E%3Cpath d='m15 18-6-6 6-6'/%3E%3C/svg%3E\")",
                'bredcrumb-chevron-ltr-light':
                    "url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%23e8eeff' stroke-width='1' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='9 18 15 12 9 6'%3E%3C/polyline%3E%3C/svg%3E\")",
                'bredcrumb-chevron-rtl-light':
                    "url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='none' stroke='%23e8eeff' stroke-linecap='round' stroke-linejoin='round' stroke-width='1'%3E%3Cpath d='m15 18-6-6 6-6'/%3E%3C/svg%3E\")",
                'bredcrumb-chevron-ltr-darkmode':
                    "url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%23718096' stroke-width='1' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='9 18 15 12 9 6'%3E%3C/polyline%3E%3C/svg%3E\")",
                'bredcrumb-chevron-rtl-darkmode':
                    "url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='none' stroke='%23718096' stroke-linecap='round' stroke-linejoin='round' stroke-width='1'%3E%3Cpath d='m15 18-6-6 6-6'/%3E%3C/svg%3E\")",

                'arrows-up-down':
                    "url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='currentColor' viewBox='0 0 320 512'%3E%3Cpath d='M171.3 4.7c-6.1-6.1-15.9-6.3-22.2-.4l-104 96c-6.5 6-6.9 16.1-.9 22.6s16.1 6.9 22.6.9L144 52.5v404.9l-68.7-68.7c-6.2-6.2-16.4-6.2-22.6 0s-6.2 16.4 0 22.6l96 96c6.2 6.2 16.4 6.2 22.6 0l96-96c6.2-6.2 6.2-16.4 0-22.6s-16.4-6.2-22.6 0L176 457.4V54.6l68.7 68.7c6.2 6.2 16.4 6.2 22.6 0s6.2-16.4 0-22.6l-96-96z'/%3E%3C/svg%3E\")",
                sort: "url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='currentColor' viewBox='0 0 320 512'%3E%3Cpath d='M34.2 179.7 154.4 66.2c1.4-1.3 3.5-2.2 5.6-2.2s4.2.8 5.6 2.2l120.2 113.5c1.4 1.3 2.2 3.2 2.2 5.2 0 3.9-3.2 7.1-7.1 7.1H39.1c-3.9 0-7.1-3.2-7.1-7.1 0-2 .8-3.8 2.2-5.2zm-22-23.3C4.4 163.8 0 174.1 0 184.9 0 206.5 17.5 224 39.1 224h241.8c21.6 0 39.1-17.5 39.1-39.1 0-10.8-4.4-21.1-12.3-28.4L187.6 42.9c-7.5-7-17.4-10.9-27.6-10.9s-20.1 3.9-27.6 10.9L12.3 156.4zm22 175.9c-1.4-1.3-2.2-3.2-2.2-5.2 0-3.9 3.2-7.1 7.1-7.1h241.8c3.9 0 7.1 3.2 7.1 7.1 0 2-.8 3.8-2.2 5.2L165.6 445.8c-1.4 1.3-3.5 2.2-5.6 2.2s-4.2-.8-5.6-2.2L34.2 332.3zm-22 23.3 120.2 113.5c7.4 7 17.4 10.9 27.6 10.9s20.1-3.9 27.6-10.9l120.1-113.5c7.8-7.4 12.3-17.7 12.3-28.5 0-21.6-17.5-39.1-39.1-39.1H39.1C17.5 288 0 305.5 0 327.1c0 10.8 4.4 21.1 12.3 28.5z'/%3E%3C/svg%3E\")",
                'sort-down':
                    "url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='currentColor' viewBox='0 0 320 512'%3E%3Cpath d='M154.4 445.8c1.4 1.3 3.5 2.2 5.6 2.2s4.2-.8 5.6-2.2l120.2-113.5c1.4-1.3 2.2-3.2 2.2-5.2 0-3.9-3.2-7.1-7.1-7.1H39.1c-3.9 0-7.1 3.2-7.1 7.1 0 2 .8 3.8 2.2 5.2l120.2 113.5zm-22 23.3L12.3 355.6C4.4 348.2 0 337.9 0 327.1 0 305.5 17.5 288 39.1 288h241.8c21.6 0 39.1 17.5 39.1 39.1 0 10.8-4.4 21.1-12.3 28.5L187.6 469.1c-7.4 7-17.3 10.9-27.6 10.9s-20.1-3.9-27.6-10.9z'/%3E%3C/svg%3E\")",
                'sort-up':
                    "url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='currentColor' viewBox='0 0 320 512'%3E%3Cpath d='M154.4 66.2c1.4-1.3 3.5-2.2 5.6-2.2s4.2.8 5.6 2.2l120.2 113.5c1.4 1.3 2.2 3.2 2.2 5.2 0 3.9-3.2 7.1-7.1 7.1H39.1c-3.9 0-7.1-3.2-7.1-7.1 0-2 .8-3.8 2.2-5.2L154.4 66.2zm-22-23.3L12.3 156.4C4.4 163.8 0 174.1 0 184.9 0 206.5 17.5 224 39.1 224h241.8c21.6 0 39.1-17.5 39.1-39.1 0-10.8-4.4-21.1-12.3-28.5L187.6 42.9c-7.5-7-17.4-10.9-27.6-10.9s-20.1 3.9-27.6 10.9z'/%3E%3C/svg%3E\")"
            },
            keyframes: {
                // Side & simple menu
                'intro-divider': {
                    '100%': {
                        opacity: 1
                    }
                },
                'intro-menu': {
                    '100%': {
                        opacity: 1,
                        transform: 'translateX(0px)'
                    }
                },

                // Top menu
                'intro-top-menu': {
                    '100%': {
                        opacity: 1,
                        transform: 'translateY(0px)'
                    }
                },

                'active-side-menu-chevron': {
                    '100%': {
                        opacity: 1,
                        'margin-right': '-27px'
                    }
                },

                'active-top-menu-chevron': {
                    '100%': {
                        opacity: 1,
                        'margin-bottom': '-56px'
                    }
                }
            },
            gridTemplateColumns: {
                // Simple 13 column grid
                13: 'repeat(13, minmax(0, 1fr))'
            },
            padding: {
                'safe-top': 'env(safe-area-inset-top)',
                'safe-right': 'env(safe-area-inset-right)',
                'safe-bottom': 'env(safe-area-inset-bottom)',
                'safe-left': 'env(safe-area-inset-left)'
            },
            margin: {
                'safe-top': 'env(safe-area-inset-top)',
                'safe-right': 'env(safe-area-inset-right)',
                'safe-bottom': 'env(safe-area-inset-bottom)',
                'safe-left': 'env(safe-area-inset-left)'
            }
        }
    },

    variants: {
        extend: {
            boxShadow: ['dark']
        }
    },

    plugins: [
        containerQueries,
        typography,
        forms,
        plugin(function ({ addBase, matchUtilities }) {
            addBase({
                // Default colors
                ':root': {
                    'color-scheme': 'light',
                    '--color-theme-1': toRGB(colors.blue['800']),
                    '--color-theme-2': toRGB(colors.blue['900']),
                    '--color-primary': toRGB(colors.blue['900']),
                    '--color-secondary': toRGB(colors.slate['200']),
                    '--color-success': toRGB(colors.lime['500']),
                    '--color-info': toRGB(colors.cyan['500']),
                    '--color-warning': toRGB(colors.yellow['400']),
                    '--color-pending': toRGB(colors.orange['500']),
                    '--color-danger': toRGB(colors.red['600']),
                    '--color-light': toRGB(colors.slate['100']),
                    '--color-dark': toRGB(colors.slate['800'])
                },
                // Default dark-mode colors
                '.dark': {
                    'color-scheme': 'dark',
                    '--color-primary': toRGB(colors.blue['700']),
                    '--color-darkmode-50': '87 103 132',
                    '--color-darkmode-100': '74 90 121',
                    '--color-darkmode-200': '65 81 114',
                    '--color-darkmode-300': '53 69 103',
                    '--color-darkmode-400': '48 61 93',
                    '--color-darkmode-500': '41 53 82',
                    '--color-darkmode-600': '40 51 78',
                    '--color-darkmode-700': '35 45 69',
                    '--color-darkmode-800': '27 37 59',
                    '--color-darkmode-900': '15 23 42'
                },
                // Theme 1 colors
                '.theme_1': {
                    '--color-theme-1': toRGB(colors.emerald['800']),
                    '--color-theme-2': toRGB(colors.emerald['900']),
                    '--color-primary': toRGB(colors.emerald['900']),
                    '--color-secondary': toRGB(colors.slate['200']),
                    '--color-success': toRGB(colors.emerald['600']),
                    '--color-info': toRGB(colors.cyan['500']),
                    '--color-warning': toRGB(colors.yellow['400']),
                    '--color-pending': toRGB(colors.amber['500']),
                    '--color-danger': toRGB(colors.rose['600']),
                    '--color-light': toRGB(colors.slate['100']),
                    '--color-dark': toRGB(colors.slate['800']),
                    '&.dark': {
                        '--color-primary': toRGB(colors.emerald['800'])
                    }
                },
                // Theme 2 colors
                '.theme_2': {
                    '--color-theme-1': toRGB(colors.blue['900']),
                    '--color-theme-2': toRGB(colors.blue['950']),
                    '--color-primary': toRGB(colors.blue['950']),
                    '--color-secondary': toRGB(colors.slate['200']),
                    '--color-success': toRGB(colors.teal['600']),
                    '--color-info': toRGB(colors.cyan['500']),
                    '--color-warning': toRGB(colors.amber['500']),
                    '--color-pending': toRGB(colors.orange['500']),
                    '--color-danger': toRGB(colors.red['700']),
                    '--color-light': toRGB(colors.slate['100']),
                    '--color-dark': toRGB(colors.slate['800']),
                    '&.dark': {
                        '--color-primary': toRGB(colors.blue['800'])
                    }
                },
                // Theme 3 colors
                '.theme_3': {
                    '--color-theme-1': toRGB(colors.cyan['800']),
                    '--color-theme-2': toRGB(colors.cyan['900']),
                    '--color-primary': toRGB(colors.cyan['900']),
                    '--color-secondary': toRGB(colors.slate['200']),
                    '--color-success': toRGB(colors.teal['600']),
                    '--color-info': toRGB(colors.cyan['500']),
                    '--color-warning': toRGB(colors.amber['500']),
                    '--color-pending': toRGB(colors.amber['600']),
                    '--color-danger': toRGB(colors.red['700']),
                    '--color-light': toRGB(colors.slate['100']),
                    '--color-dark': toRGB(colors.slate['800']),
                    '&.dark': {
                        '--color-primary': toRGB(colors.cyan['800'])
                    }
                },
                // Theme 4 colors
                '.theme_4': {
                    '--color-theme-1': toRGB(colors.indigo['800']),
                    '--color-theme-2': toRGB(colors.indigo['900']),
                    '--color-primary': toRGB(colors.indigo['900']),
                    '--color-secondary': toRGB(colors.slate['200']),
                    '--color-success': toRGB(colors.emerald['600']),
                    '--color-info': toRGB(colors.cyan['500']),
                    '--color-warning': toRGB(colors.yellow['500']),
                    '--color-pending': toRGB(colors.orange['600']),
                    '--color-danger': toRGB(colors.red['700']),
                    '--color-light': toRGB(colors.slate['100']),
                    '--color-dark': toRGB(colors.slate['800']),
                    '&.dark': {
                        '--color-primary': toRGB(colors.indigo['700'])
                    }
                }
            })

            // Animation delay utilities
            matchUtilities(
                {
                    'animate-delay': (value) => ({
                        'animation-delay': value
                    })
                },
                {
                    values: (() => {
                        const values = {}

                        for (let i = 1; i <= 50; i++) {
                            values[i * 10] = `${i * 0.1}s`
                        }

                        return values
                    })()
                }
            )

            // Animation fill mode utilities
            matchUtilities(
                {
                    'animate-fill-mode': (value) => ({
                        'animation-fill-mode': value
                    })
                },
                {
                    values: {
                        none: 'none',
                        forwards: 'forwards',
                        backwards: 'backwards',
                        both: 'both'
                    }
                }
            )
        })
    ]
}
