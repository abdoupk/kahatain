import { defineStore } from 'pinia'

interface State {
    zakat: {
        families: string[]
        zakat_id: string
        amount: number | null
        note?: string
        name: string
    }

    zakats: any
}

export const useZakatStore = defineStore('zakat', {
    state: (): State => ({
        zakat: {
            families: [],
            zakat_id: '',
            amount: null,
            note: '',
            name: ''
        },
        zakats: []
    }),
    actions: {
        async getZakats() {
            const response = await axios.get(route('tenant.list.available-zakats'))

            this.zakats = response.data
        }
    }
})
