import axios from 'axios'
import { defineStore } from 'pinia'

export const useFamiliesStore = defineStore('families', {
    state: () => ({
        families: []
    }),
    actions: {
        async searchFamilies(query: string) {
            const { data: families } = await axios.get(route('tenant.families.search', query))

            return families
        }
    }
})
