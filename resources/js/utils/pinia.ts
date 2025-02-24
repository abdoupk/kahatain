import { type PiniaPluginContext } from 'pinia'

export const usePersistStore = (context: PiniaPluginContext) => {
    const { store } = context

    if (!['create-family', 'settings'].includes(store.$id)) {
        return
    }

    const persistedState = localStorage.getItem(`pinia-state-${store.$id}`)

    if (persistedState) {
        store.$patch(JSON.parse(persistedState))
    }

    store.$subscribe((mutation, state) => {
        localStorage.setItem(`pinia-state-${store.$id}`, JSON.stringify(state))
    })
}
