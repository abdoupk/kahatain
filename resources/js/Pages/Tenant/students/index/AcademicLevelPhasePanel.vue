<script lang="ts" setup>
import { AcademicLevelsIndexResource } from '@/types/lessons'

import { Link } from '@inertiajs/vue3'

import BaseTabPanel from '@/Components/Base/headless/Tab/BaseTabPanel.vue'
import BaseTabPanels from '@/Components/Base/headless/Tab/BaseTabPanels.vue'
import BaseTippy from '@/Components/Base/tippy/BaseTippy.vue'
import SvgLoader from '@/Components/Global/SvgLoader.vue'

defineProps<{
    phases: AcademicLevelsIndexResource
}>()
</script>

<template>
    <base-tab-panels class="px-5 pb-5">
        <base-tab-panel v-for="(phase, key) in phases" :key class="grid grid-cols-12 gap-x-10 gap-y-8">
            <div v-for="level in phase" :key="level" class="col-span-12 sm:col-span-6 md:col-span-4">
                <Link
                    :href="
                        route('tenant.students.phase.index', {
                            phase: key.replace('_', '-'),
                            academicLevel: level.id
                        })
                    "
                    class="text-slate-500 rtl:!font-semibold"
                >
                    <span class="inline"> {{ level.level }}</span>

                    <svg-loader class="ms-1.5 inline h-5 w-5" name="icon-link"></svg-loader>
                </Link>

                <div class="mt-1.5 flex items-center">
                    <div class="text-base">
                        {{ level.orphans_count }}
                    </div>

                    <base-tippy
                        class="ms-2 flex cursor-pointer text-xs font-medium text-danger"
                        content="2% Lower than last month"
                    >
                        {{ level.achievement_percentage }}%
                    </base-tippy>
                </div>
            </div>
        </base-tab-panel>
    </base-tab-panels>
</template>
