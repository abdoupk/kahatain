import axios from 'axios'
import { defineStore } from 'pinia'

export const useVocationalTrainingStore = defineStore('vocational-training', {
    state: () => ({
        vocationalTrainingSpecialities: []
    }),
    actions: {
        async getVocationalTrainingSpecialities() {
            if (this.vocationalTrainingSpecialities.length === 0) {
                const { data: vocationalTrainingSpecialities } = await axios.get(
                    route('tenant.list.vocational-trainings-specialities')
                )

                this.vocationalTrainingSpecialities = vocationalTrainingSpecialities
            }
        }
    }
})
