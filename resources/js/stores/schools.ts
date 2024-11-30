import type { SubjectType } from '@/types/lessons'
import type { CreateSchoolForm } from '@/types/types'

import axios from 'axios'
import { defineStore } from 'pinia'

interface State {
    school: CreateSchoolForm & {
        id?: string
        lessons_count?: number
        readable_created_at?: string
        creator?: {
            id: string
            name: string
        }
    }
    schools: CreateSchoolForm &
        {
            id: string
            subjects: SubjectType[]
        }[]
}

export const useSchoolsStore = defineStore('schools', {
    state: (): State => ({
        school: {
            id: '',
            name: '',
            lessons: [
                {
                    quota: null,
                    academic_level_id: null,
                    subject_id: null
                }
            ]
        },
        schools: []
    }),
    actions: {
        async getSchool(schoolId: string) {
            const {
                data: { school }
            } = await axios.get(route('tenant.schools.show', schoolId))

            this.school = { ...school }
        },

        async getSchoolDetails(schoolId: string) {
            const { data } = await axios.get(route('tenant.schools.details', schoolId))

            this.school = data.school
        },

        async getSchools() {
            if (this.schools.length) {
                return
            }

            const { data: schools } = await axios.get(route('tenant.list.schools'))

            this.schools = schools
        },

        findSchoolById(id: string) {
            return this.schools.find((school) => school.id === id)
        },

        getQuotaAndAcademicLevel(schoolId: string, subjectId: number) {
            return this.schools
                .find((school) => school.id === schoolId)
                .subjects.find((subject) => subject.id === subjectId)
        },

        async searchSchools(search: string, phase_key: string) {
            const { data: schools } = await axios.get(
                route('tenant.schools.search-schools', {
                    search,
                    phase_key,
                    city_id: 1144
                })
            )

            return schools
        },

        async searchUniversities(search: string) {
            const { data: universities } = await axios.get(route('tenant.schools.search-universities', { search }))

            return universities
        }
    }
})
