import { PageProps as AppPageProps } from './'

import { PageProps as InertiaPageProps } from '@inertiajs/core'
import { AxiosInstance } from 'axios'
import type Echo from 'laravel-echo'
import { route as ziggyRoute } from 'ziggy-js'

declare global {
    interface Window {
        axios: AxiosInstance

        Echo: Echo
    }

    let route: typeof ziggyRoute
}

declare module 'vue' {
    interface ComponentCustomProperties {
        route: typeof ziggyRoute
        $t: (key: string, replacements?: Record<string, string>) => string
        __: (key: string, replacements?: Record<string, string>) => string
        n__: (key: string, number: number, replacements?: Record<string, string>) => string
    }
}

declare module '@inertiajs/core' {
    interface PageProps extends InertiaPageProps, AppPageProps {}
}
