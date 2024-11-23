import { defineStore } from 'pinia'

interface State {
    zakat: {
        checked_families: string[]
    }
}

export const useZakatStore = defineStore('zakat', {
    state: (): State => ({
        zakat: {
            checked_families: []
        }
    })
})
