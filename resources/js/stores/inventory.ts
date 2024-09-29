import type { AddItemToInventoryForm } from '@/types/types'

import axios from 'axios'
import { defineStore } from 'pinia'

interface State {
    item: AddItemToInventoryForm & {
        id?: string
        readable_created_at?: string
        creator?: {
            id: string
            name: string
        }
        qty_for_family?: number | null
    }
    diapers: {
        id: string
        name: string
    }[]
    babyMilk: {
        id: string
        name: string
    }[]
}

export const useInventoryStore = defineStore('inventory', {
    state: (): State => ({
        item: {
            id: '',
            name: '',
            qty: null,
            qty_for_family: 0,
            unit: 'kg',
            type: '',
            note: ''
        },
        babyMilk: [],
        diapers: []
    }),
    actions: {
        async getItem(itemId: string) {
            const {
                data: { item }
            } = await axios.get(`inventory/show/${itemId}`)

            this.item = { ...item }
        },

        async getItemDetails(itemId: string) {
            const { data } = await axios.get(route('tenant.items.details', itemId))

            this.item = data.item
        },

        async getBabyMilk() {
            if (this.babyMilk.length > 0) {
                return
            }

            const { data: babyMilk } = await axios.get(route('tenant.list.baby-milk'))

            this.babyMilk = babyMilk
        },

        findBabyMilkById(id: string) {
            return this.babyMilk.find((babyMilk) => babyMilk.id === id)
        },

        async getDiapers() {
            if (this.diapers.length > 0) {
                return
            }

            const { data: diapers } = await axios.get(route('tenant.list.diapers'))

            this.diapers = diapers
        },

        findDiaperById(id: string) {
            return this.diapers.find((diaper) => diaper.id === id)
        }
    }
})
