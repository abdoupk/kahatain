import axios from 'axios'
import { defineStore } from 'pinia'

export const useOrphansStore = defineStore('orphan', {
    state: () => ({
        orphans: []
    }),
    actions: {
        async getOrphans() {
            const { data: orphans } = await axios.get(route('tenant.lessons.list-orphans'))

            this.orphans = orphans
        },

        async searchOrphans(search: string) {
            const { data: orphans } = await axios.get(route('tenant.orphans.search', { search }))

            return orphans
        }
    }
})
