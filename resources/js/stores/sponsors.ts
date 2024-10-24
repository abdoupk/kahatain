import axios from 'axios'
import { defineStore } from 'pinia'

export const useSponsorsStore = defineStore('sponsors', {
    state: () => ({
        sponsors: []
    }),
    actions: {
        async searchSponsors(search: string) {
            const { data: sponsors } = await axios.get(route('tenant.sponsors.search', { search }))

            return sponsors
        }
    }
})
