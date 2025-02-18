import axios from 'axios'
import { defineStore } from 'pinia'

export const useAcademicLevelsStore = defineStore('academic-levels', {
    state: () => ({
        academicLevels: []
    }),
    getters: {
        // GetAcademicLevels: (state) => state.academicLevels
        // GetAcademicLevelByID: (state) => (id) => state.academicLevels.find((academicLevel) => academicLevel.id === id)
    },
    actions: {
        async getAcademicLevels() {
            if (this.academicLevels.length == 0) {
                const { data: academicLevels } = await axios.get(route('tenant.list.academic-levels'))

                this.academicLevels = academicLevels
            }
        },

        async getAcademicLevelsForOrphans() {
            if (this.academicLevels.length == 0) {
                await this.getAcademicLevels()
            }

            return this.academicLevels.map((item) => {
                const newItem = { ...item }

                newItem.levels = item.levels.filter((level) => level.name !== 'امي')

                return newItem
            })
        },

        async getAcademicLevelsForSelectLessons() {
            if (this.academicLevels.length == 0) {
                await this.getAcademicLevels()
            }

            return this.academicLevels.filter((academicLevel) =>
                // eslint-disable-next-line array-element-newline
                ['primary_education', 'middle_education', 'secondary_education'].includes(academicLevel.phase_key)
            )
        },

        async getAcademicLevelsForSponsors() {
            if (this.academicLevels.length == 0) {
                await this.getAcademicLevels()
            }

            return this.academicLevels.map((item) => {
                const newItem = { ...item }

                newItem.levels = item.levels.filter((level) => !['مفصول', 'تحضيري'].includes(level.name))

                return newItem
            })
        },

        async getAcademicLevelsForOrphansForSelectCollege() {
            if (this.academicLevels.length == 0) {
                await this.getAcademicLevels()
            }

            return this.academicLevels.filter((academicLevel) => academicLevel.phase_key === 'university')
        },

        async getAcademicLevelsForTraineesForSelect() {
            if (this.academicLevels.length == 0) {
                await this.getAcademicLevels()
            }

            return this.academicLevels.filter((academicLevel) =>
                ['paramedical', 'vocational_training'].includes(academicLevel.phase_key)
            )
        },

        async getAcademicLevelsForSponsorsForSelectFilterValue() {
            await this.getAcademicLevels()

            return this.academicLevels
                .filter((academicLevel) => academicLevel.phase != 'التكوين المهني')
                .filter((academicLevel) => academicLevel.phase != 'الشبه الطبي')
                .flatMap(({ levels }) =>
                    levels
                        .filter((level) => level.name !== 'تحضيري')
                        .filter((level) => level.name !== 'مفصول')
                        .map(({ id, name }) => ({
                            id,
                            name
                        }))
                )
        },

        async getAcademicLevelsForOrphansForSelectFilterValue() {
            await this.getAcademicLevels()

            return this.academicLevels.flatMap(({ levels, phase }) =>
                levels
                    .filter((level) => level.name !== 'امي')
                    .map(({ id, name }) => ({
                        id,
                        name: phase === 'التكوين المهني' || phase === 'الشبه طبي' ? `${name} (${phase})` : name
                    }))
            )
        },

        async getAcademicLevelsForMembersForSelectFilterValue() {
            await this.getAcademicLevels()

            return this.academicLevels
                .filter(
                    (academicLevel) =>
                        !['الطور الابتدائي',
                            'الطور المتوسط',
                            'الطور الثانوي'].includes(academicLevel.phase)
                )
                .flatMap(({ levels, phase }) =>
                    levels
                        .filter((level) => level.name !== 'امي' && level.name !== 'مفصول')
                        .map(({ id, name }) => ({
                            id,
                            name: phase === 'التكوين المهني' || phase === 'الشبه طبي' ? `${name} (${phase})` : name
                        }))
                )
        },

        getPhaseFromId(id: number) {
            for (const item of this.academicLevels) {
                const level = item.levels.find((level) => level.id === id)

                if (level) {
                    return item.phase_key
                }
            }

            return null
        }
    }
})
