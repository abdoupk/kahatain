<script lang="ts" setup>
import { StudentsPerInstitution, StudentsPerPhase } from '@/types/orphans'

import { twMerge } from 'tailwind-merge'

import AcademicLevelPhaseDonutChart from '@/Pages/Tenant/students/index/AcademicLevelPhaseDonutChart.vue'

import BasePolarBarChart from '@/Components/Base/chart/BasePolarBarChart.vue'

import { $t } from '@/utils/i18n'

defineProps<{
    collegeStudentsPerPhase: StudentsPerPhase
    studentsPerUniversity: StudentsPerInstitution
    totalCollegeStudents: number
}>()
</script>

<template>
    <!-- BEGIN: Students by Academic Phases Chart -->
    <div class="col-span-12 mt-8 sm:col-span-6">
        <div class="intro-y flex h-10 items-center">
            <h2 class="me-5 truncate text-lg font-medium rtl:font-semibold">
                {{ $t('statistics') }}
            </h2>
        </div>

        <div
            class="intro-y relative mt-5 before:absolute before:inset-x-0 before:mx-auto before:mt-2.5 before:hidden before:h-full before:w-[90%] before:rounded-md before:bg-white/60 before:shadow-[0px_3px_5px_#0000000b] before:content-[''] before:dark:bg-darkmode-400/70 xl:before:block"
        >
            <div class="box p-5">
                <div class="mt-3 flex items-center justify-center">
                    <academic-level-phase-donut-chart
                        :data="collegeStudentsPerPhase.map((student) => student.total)"
                        :height="200"
                        :labels="collegeStudentsPerPhase.map((student) => $t(`phase_${student.phase}`))"
                        :width="200"
                    ></academic-level-phase-donut-chart>
                </div>

                <div class="mx-auto mt-8 w-52 sm:w-auto">
                    <div
                        v-for="student in collegeStudentsPerPhase"
                        :key="student.phase"
                        class="mt-4 flex items-center first:mt-0"
                    >
                        <div
                            :class="
                                twMerge([
                                    student.phase === 'licence' && 'bg-pending',
                                    student.phase === 'doctorate' && 'bg-warning',
                                    student.phase === 'master' && 'bg-primary'
                                ])
                            "
                            class="me-3 h-2 w-2 rounded-full"
                        ></div>

                        <span class="truncate">{{ $t(`phase_${student.phase}`) }}</span>

                        <span class="ms-auto font-medium">
                            {{ (Math.round(((student.total * 100) / totalCollegeStudents) * 100) / 100).toFixed(2) }} %
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Students by Academic Phases Chart -->

    <!-- BEGIN: Students by School Chart -->
    <div class="col-span-12 sm:col-span-6 sm:mt-20">
        <div
            class="intro-y relative mt-5 before:absolute before:inset-x-0 before:mx-auto before:mt-2.5 before:hidden before:h-full before:w-[90%] before:rounded-md before:bg-white/60 before:shadow-[0px_3px_5px_#0000000b] before:content-[''] before:dark:bg-darkmode-400/70 xl:before:block"
        >
            <div class="box p-5 sm:-mt-2">
                <h2 class="me-5 truncate text-lg font-medium rtl:font-semibold">
                    {{ $t('top_seven_universities') }}
                </h2>
                <div class="mt-3 flex items-center justify-center">
                    <base-polar-bar-chart
                        :chart-data="studentsPerUniversity.map((university) => university.total)"
                        :height="300"
                        :labels="studentsPerUniversity.map((university) => university.name)"
                        :width="300"
                        hide-legend
                    ></base-polar-bar-chart>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Students by School Chart -->
</template>
