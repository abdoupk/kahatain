import type { SubjectType } from '@/types/types'

import axios from 'axios'
import { defineStore } from 'pinia'

interface State {
    subjects: SubjectType[]
}

export const useSubjectsStore = defineStore('subjects', {
    state: (): State => ({
        subjects: []
    }),
    actions: {
        async getSubjects() {
            if (this.subjects.length > 0) {
                return
            }

            const response = await axios.get(route('tenant.list.subjects'))

            this.subjects = response.data
        },

        findSubjectById(id: number | undefined) {
            return this.subjects.find((subject) => subject.id == id)
        }
    }
})
