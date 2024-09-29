import type { CreateVocationalTrainingAchievementForm } from '@/types/vocational-training-achievement'

import axios from 'axios'
import { defineStore } from 'pinia'

interface State {
    vocationalTrainingAchievement: CreateVocationalTrainingAchievementForm & {
        id: string
    }
}

export const useVocationalTrainingAchievementsStore = defineStore('vocational-training-achievements', {
    state: (): State => ({
        vocationalTrainingAchievement: {
            id: '',
            orphan_id: '',
            note: '',
            institute: null,
            year: new Date().getFullYear(),
            vocational_training_id: null
        }
    }),
    actions: {
        async getVocationalTrainingAchievement(VocationalTrainingAchievementID: string) {
            await axios
                .get(route('tenant.vocational-training-achievements.show', VocationalTrainingAchievementID))
                .then((res) => {
                    this.vocationalTrainingAchievement = { ...res.data.vocational_training_achievement }
                })
        }
    }
})
