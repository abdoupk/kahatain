import axios from 'axios'
import { defineStore } from 'pinia'

export const useVocationalTrainingStore = defineStore('vocational-training', {
    state: () => ({
        vocationalTrainingSpecialities: [],
        universitySpecialities: []
    }),
    actions: {
        async getVocationalTrainingSpecialities() {
            if (this.vocationalTrainingSpecialities.length === 0) {
                const { data: vocationalTrainingSpecialities } = await axios.get(
                    route('tenant.list.vocational-trainings-specialities')
                )

                this.vocationalTrainingSpecialities = vocationalTrainingSpecialities
            }
        },

        async getUniversitySpecialities() {
            if (this.universitySpecialities.length === 0) {
                const { data: universitySpecialities } = await axios.get(route('tenant.list.university-specialities'))

                this.universitySpecialities = universitySpecialities
            }
        },

        async searchSpecialities(search: string) {
            const { data: specialities } = await axios.get(route('tenant.vocational-training.search', { search }))

            return specialities
        },

        async searchUniversitySpecialities(search: string) {
            const { data: specialities } = await axios.get(
                route('tenant.schools.search-university-specialities', { search })
            )

            return specialities
        },

        async searchTraineesSpecialities(search: string) {
            const { data: specialities } = await axios.get(route('tenant.vocational-training.search', { search }))

            return specialities
        },

        async searchVocationalTrainingCenters(search: string) {
            const { data: centers } = await axios.get(
                route('tenant.vocational-training.search-vocational-training-centers', { search })
            )

            return centers
        }
    }
})
