<script lang="ts" setup>
import { StudentsPerInstitution, StudentsPerPhase } from '@/types/orphans'

import { twMerge } from 'tailwind-merge'

import AcademicLevelPhaseDonutChart from '@/Pages/Tenant/students/index/AcademicLevelPhaseDonutChart.vue'

import BasePolarBarChart from '@/Components/Base/chart/BasePolarBarChart.vue'
import TheNoDataChart from '@/Components/Global/TheNoDataChart.vue'

import { $t } from '@/utils/i18n'

defineProps<{
    traineesPerPhase: StudentsPerPhase
    traineesPerInstitution: StudentsPerInstitution
    totalTrainees: number
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
            <div class="box h-[380px] p-5">
                <template v-if="traineesPerPhase.length > 0">
                    <div class="mt-3 flex items-center justify-center">
                        <academic-level-phase-donut-chart
                            :data="traineesPerPhase.map((student) => student.total)"
                            :height="200"
                            :labels="traineesPerPhase.map((student) => $t(`phase_${student.phase}`))"
                            :width="200"
                        ></academic-level-phase-donut-chart>
                    </div>

                    <div class="mx-auto mt-8 w-52 sm:w-auto">
                        <div
                            v-for="student in traineesPerPhase"
                            :key="student.phase"
                            class="mt-4 flex items-center first:mt-0"
                        >
                            <div
                                :class="
                                    twMerge([
                                        student.phase === 'paramedical' && 'bg-pending',
                                        student.phase === 'vocational_training' && 'bg-warning'
                                    ])
                                "
                                class="me-3 h-2 w-2 rounded-full"
                            ></div>

                            <span class="truncate">{{ $t(`phase_${student.phase}`) }}</span>

                            <span class="ms-auto font-medium">
                                {{ (Math.round(((student.total * 100) / totalTrainees) * 100) / 100).toFixed(2) }} %
                            </span>
                        </div>
                    </div>
                </template>

                <the-no-data-chart v-else></the-no-data-chart>
            </div>
        </div>
    </div>
    <!-- END: Students by Academic Phases Chart -->

    <!-- BEGIN: Students by School Chart -->
    <div class="col-span-12 sm:col-span-6 sm:mt-20">
        <div
            class="intro-y relative mt-5 before:absolute before:inset-x-0 before:mx-auto before:mt-2.5 before:hidden before:h-full before:w-[90%] before:rounded-md before:bg-white/60 before:shadow-[0px_3px_5px_#0000000b] before:content-[''] before:dark:bg-darkmode-400/70 xl:before:block"
        >
            <div class="box h-[380px] p-5 sm:-mt-2">
                <template v-if="traineesPerInstitution.length > 0">
                    <h2 class="me-5 truncate text-lg font-medium rtl:font-semibold">
                        {{ $t('top_seven_centers') }}
                    </h2>
                    <div class="mt-3 flex items-center justify-center">
                        <base-polar-bar-chart
                            :chart-data="traineesPerInstitution.map((institution) => institution.total)"
                            :height="260"
                            :labels="traineesPerInstitution.map((institution) => institution.name)"
                            :width="300"
                            hide-legend
                        ></base-polar-bar-chart>
                    </div>
                </template>

                <the-no-data-chart v-else></the-no-data-chart>
            </div>
        </div>
    </div>
    <!-- END: Students by School Chart -->
</template>
