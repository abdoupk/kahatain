import { defineStore } from 'pinia'

export const useCompetencesStore = defineStore('competences', {
    state: () => ({
        competences: []
    }),
    actions: {
        async fetchCompetences() {
            if (this.comptences.length === 0) {
                const {
                    data: { competences }
                } = await axios.get(route('api.list-competences'))

                this.competences = competences
            }
        }
    }
})
