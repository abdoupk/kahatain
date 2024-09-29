import type { CreateAcademicAchievementForm } from '@/types/academic-achievement'

import axios from 'axios'
import { defineStore } from 'pinia'

interface State {
    academicAchievement: CreateAcademicAchievementForm & {
        id: string
    }
}

export const useAcademicAchievementsStore = defineStore('academic-achievements', {
    state: (): State => ({
        academicAchievement: {
            id: '',
            academic_level_id: null,
            academic_year: new Date().getFullYear(),
            first_trimester: null,
            second_trimester: null,
            third_trimester: null,
            average: null,
            orphan_id: '',
            note: ''
        }
    }),
    actions: {
        async getAcademicAchievement(AcademicAchievementID: string) {
            await axios.get(route('tenant.academic-achievements.show', AcademicAchievementID)).then((res) => {
                this.academicAchievement = { ...res.data.academic_achievement }
            })
        }
    }
})
