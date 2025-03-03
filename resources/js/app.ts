import './bootstrap'
import './echo'

import { createInertiaApp, router } from '@inertiajs/vue3'
import { isAxiosError } from 'axios'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import { createPinia } from 'pinia'
import { type DefineComponent, createApp, h } from 'vue'
import { ZiggyVue } from 'ziggy-js'

import i18n, { $t } from '@/utils/i18n'
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
            .use(plugin)
            .use(pinia)
            .use(ZiggyVue)
            .use(i18n)

        if (import.meta.env.MODE !== 'development') {
            app.config.errorHandler = async (err) => {
                if (isAxiosError(err)) {
                    const { toast } = await import('vue-sonner')

                    switch (err.response?.status) {
                        case 401:
                            toast($t('errors.descriptions.401'))

                            break

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
        }

        // @ts-expect-error
        delete el.dataset.page

        app.mount(el)
    },
    progress: {
        color: '#4B5563'
    }
}).then(() => {})
