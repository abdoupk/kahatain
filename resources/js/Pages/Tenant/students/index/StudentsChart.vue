<script lang="ts" setup>
import { StudentsPerPhase } from '@/types/orphans'

import { twMerge } from 'tailwind-merge'

import AcademicLevelPhaseDonutChart from '@/Pages/Tenant/students/index/AcademicLevelPhaseDonutChart.vue'

import { $t } from '@/utils/i18n'

defineProps<{
    totalStudents: number
    studentsPerPhase: StudentsPerPhase
}>()
</script>

<template>
    <!-- BEGIN: Students Chart -->
    <div class="col-span-12 mt-8 sm:col-span-6">
        <div class="intro-y flex h-10 items-center">
            <h2 class="me-5 truncate text-lg font-medium">Report</h2>
        </div>

        <div
            class="intro-y relative mt-5 before:absolute before:inset-x-0 before:mx-auto before:mt-2.5 before:hidden before:h-full before:w-[90%] before:rounded-md before:bg-white/60 before:shadow-[0px_3px_5px_#0000000b] before:content-[''] before:dark:bg-darkmode-400/70 xl:before:block"
        >
            <div class="box p-5">
                <div class="mt-3 flex items-center justify-center">
                    <academic-level-phase-donut-chart
                        :data="studentsPerPhase.map((student) => student.total)"
                        :height="200"
                        :labels="studentsPerPhase.map((student) => $t(`phase_${student.phase}`))"
                        :width="200"
                    ></academic-level-phase-donut-chart>
                </div>

                <div class="mx-auto mt-8 w-52 sm:w-auto">
                    <div
                        v-for="student in studentsPerPhase"
                        :key="student.phase"
                        class="mt-4 flex items-center first:mt-0"
                    >
                        <div
                            :class="
                                twMerge([
                                    student.phase === 'middle_education' && 'bg-pending',
                                    student.phase === 'primary_education' && 'bg-warning',
                                    student.phase === 'secondary_education' && 'bg-primary'
                                ])
                            "
                            class="me-3 h-2 w-2 rounded-full"
                        ></div>

                        <span class="truncate">{{ $t(`phase_${student.phase}`) }}</span>

                        <span class="ms-auto font-medium">
                            {{ (Math.round(((student.total * 100) / totalStudents) * 100) / 100).toFixed(2) }} %
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Students Chart -->
</template>
