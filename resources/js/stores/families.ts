import axios from 'axios'
import { defineStore } from 'pinia'

export const useFamiliesStore = defineStore('families', {
    state: () => ({
        families: []
    }),
    actions: {
        async searchFamilies(search: string) {
            const { data: families } = await axios.get(route('tenant.families.search', { search }))

            return families
        }
    }
})
