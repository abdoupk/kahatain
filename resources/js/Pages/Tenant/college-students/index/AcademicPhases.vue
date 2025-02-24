<script lang="ts" setup>
import { AcademicLevelsIndexResource } from '@/types/lessons'

import AcademicLevelPhasePanel from '@/Pages/Tenant/college-students/index/AcademicLevelPhasePanel.vue'
import AcademicLevelTab from '@/Pages/Tenant/college-students/index/AcademicLevelTab.vue'

import BaseTabGroup from '@/Components/Base/headless/Tab/BaseTabGroup.vue'
import BaseTabList from '@/Components/Base/headless/Tab/BaseTabList.vue'
import SvgLoader from '@/Components/SvgLoader.vue'

defineProps<{
    academicLevels: AcademicLevelsIndexResource
    totalCollegeStudents: number
}>()
</script>

<template>
    <!-- BEGIN: General Report -->
    <div class="col-span-12 mt-8">
        <div class="intro-y flex h-10 items-center">
            <h2 class="me-5 truncate text-lg font-medium rtl:!font-semibold">
                {{ $t('college_student_list') }}
            </h2>
        </div>

        <div class="intro-y mt-5">
            <div
                class="relative before:absolute before:inset-x-0 before:mx-auto before:mt-2.5 before:h-full before:w-[95%] before:rounded-md before:bg-white/60 before:shadow-[0px_3px_5px_#0000000b] before:content-[''] before:dark:bg-darkmode-400/70"
            >
                <div class="box grid grid-cols-12">
                    <div class="col-span-12 flex flex-col justify-center px-8 py-12 lg:col-span-4">
                        <svg-loader class="h-10 w-10 text-pending" name="icon-user-graduate"></svg-loader>

                        <div
                            class="mt-12 flex items-center justify-start text-base/6 text-slate-600 dark:text-slate-300 rtl:!font-semibold"
                        >
                            {{ $t('total_college_students') }}
                        </div>

                        <div class="mb-8 mt-4 flex items-center justify-start">
                            <div class="relative ms-0.5 text-2xl font-bold">
                                {{ totalCollegeStudents }}
                            </div>
                        </div>
                    </div>

                    <div
                        class="col-span-12 border-t border-dashed border-slate-200 p-8 dark:border-darkmode-300 lg:col-span-8 lg:border-s lg:border-t-0"
                    >
                        <base-tab-group>
                            <base-tab-list
                                class="mx-auto mb-8 flex w-full rounded-md border border-dashed border-slate-300 p-1 dark:border-darkmode-300"
                                role="tablist"
                                variant="pills"
                            >
                                <academic-level-tab :phases="Object.keys(academicLevels)"></academic-level-tab>
                            </base-tab-list>

                            <academic-level-phase-panel :phases="academicLevels"></academic-level-phase-panel>
                        </base-tab-group>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: General Report -->
</template>
