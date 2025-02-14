import type { CreateLessonForm } from '@/types/types'

import axios from 'axios'
import { defineStore } from 'pinia'

interface State {
    lesson: CreateLessonForm & {
        id?: string
        subject?: {
            id: string
            name: string
        }
        school?: {
            id: string
            name: string
            subjects?: {
                id: number
                name: string
            }[]
        }
        academic_level?: {
            id: string
            name: string
        }
        orphans?: {
            id: string
            first_name: string
            last_name: string
            sponsor_phone?: string
        }[]
        formated_date?: string
    }
}

export const useLessonsStore = defineStore('lessons', {
    state: (): State => ({
        lesson: {
            orphans: [],
            id: '',
            school: [],
            subject_id: null,
            academic_level_id: null,
            school_id: '',
            title: '',
            start_date: '',
            end_date: '',
            color: '',
            frequency: '',
            interval: null,
            until: '',
            update_this_and_all_coming: true
        }
    }),
    actions: {
        async getLesson(lessonId: string) {
            const {
                data: { lesson }
            } = await axios.get(route('tenant.lessons.show', lessonId))

            this.lesson = { ...lesson }

            this.lesson.update_this_and_all_coming = true
        },
        async updateLesson(id: string, data: { start_date: string; end_date: string }) {
            await axios.put(route('tenant.lessons.update-dates', id), data)
        },

        async getOrphans(search: string, academic_level_id: number) {
            return await axios.get(route('tenant.lessons.list-orphans', { search, academic_level_id }))
        }
    }
})
