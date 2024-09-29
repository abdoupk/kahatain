import '../css/app.css'
import './bootstrap'
import './echo'
import i18n, { $t } from './utils/i18n'

import { createInertiaApp, router } from '@inertiajs/vue3'
import { isAxiosError } from 'axios'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import { createPinia } from 'pinia'
import { type DefineComponent, createApp, h } from 'vue'
import { toast } from 'vue-sonner'
import { ZiggyVue } from 'ziggy-js'

import { usePersistStore } from '@/utils/pinia'

const appName = import.meta.env.VITE_APP_NAME || 'Laravel'

const pinia = createPinia()

pinia.use(usePersistStore)

createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : `${appName}`),
    resolve: (name) =>
        resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob<DefineComponent>('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) })
            .use(i18n)
            .use(plugin)
            .use(pinia)
            .use(ZiggyVue)

        app.config.errorHandler = (err, instance, info) => {
            if (isAxiosError(err)) {
                switch (err.response?.status) {
                    case 401:
                    case 419:
                        router.post(route('tenant.logout'))
                        break
                    case 403:
                        toast($t('errors.descriptions.403'))
                        break
                    case 404:
                        toast($t('errors.descriptions.404'))
                        break
                    case 500:
                        toast($t('errors.descriptions.500'))
                        break
                }
            }
        }

        app.mount(el)

        // @ts-expect-error
        delete el.dataset.page
    },
    progress: {
        color: '#4B5563'
    }
}).then()
