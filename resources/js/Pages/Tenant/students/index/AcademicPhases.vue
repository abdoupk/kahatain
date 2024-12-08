<script lang="ts" setup>
import { AcademicLevelsIndexResource } from '@/types/lessons'

import { router } from '@inertiajs/vue3'
import { ref } from 'vue'

import AcademicLevelPhasePanel from '@/Pages/Tenant/students/index/AcademicLevelPhasePanel.vue'
import AcademicLevelTab from '@/Pages/Tenant/students/index/AcademicLevelTab.vue'

import BaseButton from '@/Components/Base/button/BaseButton.vue'
import BaseTabGroup from '@/Components/Base/headless/Tab/BaseTabGroup.vue'
import BaseTabList from '@/Components/Base/headless/Tab/BaseTabList.vue'
import TheWarningModal from '@/Components/Global/TheWarningModal.vue'
import SvgLoader from '@/Components/SvgLoader.vue'

defineProps<{
    academicLevels: AcademicLevelsIndexResource
    totalStudents: number
}>()

const newSchoolYearLoading = ref(false)

const showWarningModalStatus = ref(false)

const handleAcceptStartNewSchoolYear = () => {
    router.delete(route('tenant.students.start-new-school-year'), {
        preserveScroll: true,
        preserveState: true,
        onStart: () => {
            newSchoolYearLoading.value = true
        },
        onSuccess: () => {
            router.get(
                route('tenant.students.index'),
                {},
                {
                    preserveState: true,
                    only: ['academicLevels'],
                    preserveScroll: true,
                    onSuccess: () => {
                        newSchoolYearLoading.value = false

                        showWarningModalStatus.value = false
                    }
                }
            )
        }
    })
}

const handleDownloadSchoolTools = () => {
    const a = document.createElement('a')

    a.href = route('tenant.students.download-school-tools-list')

    a.click()

    document.body.removeChild(a)
}
</script>

<template>
    <!-- BEGIN: General Report -->
    <div class="col-span-12 mt-8">
        <div class="intro-y flex h-10 items-center">
            <h2 class="me-5 truncate text-lg font-medium">General Report</h2>
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
                            {{ $t('total_students') }}
                        </div>

                        <div class="mt-4 flex items-center justify-start">
                            <div class="relative ms-0.5 text-2xl font-bold">
                                {{ totalStudents }}
                            </div>
                        </div>

                        <base-button
                            class="relative mt-12 justify-start rounded-full font-semibold"
                            variant="outline-danger"
                            @click.prevent="showWarningModalStatus = true"
                        >
                            {{ $t('new_school_year') }}
                            <span
                                class="absolute bottom-0 end-0 top-0 my-auto me-0.5 ms-auto flex h-8 w-8 items-center justify-center rounded-full bg-danger/85 text-white"
                            >
                                <svg-loader class="h-4 w-4 fill-current" name="icon-sparkles"></svg-loader>
                            </span>
                        </base-button>

                        <base-button
                            class="relative mt-12 justify-start rounded-full font-semibold"
                            variant="outline-secondary"
                            @click.prevent="handleDownloadSchoolTools"
                        >
                            {{ $t('download_school_tools_list') }}
                            <span
                                class="absolute bottom-0 end-0 top-0 my-auto me-0.5 ms-auto flex h-8 w-8 items-center justify-center rounded-full bg-primary text-white"
                            >
                                <svg-loader class="h-4 w-4 fill-current" name="icon-chevron-left"></svg-loader>
                            </span>
                        </base-button>
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

        <the-warning-modal
            :on-progress="newSchoolYearLoading"
            :open="showWarningModalStatus"
            @accept="handleAcceptStartNewSchoolYear"
            @close="showWarningModalStatus = false"
        >
            <slot>
                {{ $t('new_school_year_confirmation_message') }}
            </slot>
        </the-warning-modal>
    </div>
    <!-- END: General Report -->
</template>
