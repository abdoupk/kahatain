import type { CreateCollegeAchievementForm } from '@/types/college-achievement'

import axios from 'axios'
import { defineStore } from 'pinia'

interface State {
    collegeAchievement: CreateCollegeAchievementForm & {
        id: string
    }
}

export const useCollegeAchievementsStore = defineStore('college-achievements', {
    state: (): State => ({
        collegeAchievement: {
            id: '',
            academic_level_id: null,
            year: new Date().getFullYear(),
            first_semester: null,
            second_semester: null,
            average: null,
            speciality: '',
            university: '',
            orphan_id: '',
            note: ''
        }
    }),
    actions: {
        async getCollegeAchievement(CollegeAchievementID: string) {
            await axios.get(route('tenant.college-achievements.show', CollegeAchievementID)).then((res) => {
                this.collegeAchievement = { ...res.data.college_achievement }
            })
        }
    }
})
