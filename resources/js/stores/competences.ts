import axios from 'axios'
import { defineStore } from 'pinia'

export const useCompetencesStore = defineStore('competences', {
    state: () => ({
        competences: []
    }),
    actions: {
        async fetchCompetences() {
            if (this.competences.length === 0) {
                const response = await axios.get(route('tenant.list.competences'))

                this.competences = response.data
            }
        }
    }
})
