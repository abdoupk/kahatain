<script lang="ts" setup>
import { AcademicLevelsIndexResource } from '@/types/lessons'

import BaseTabPanel from '@/Components/Base/headless/Tab/BaseTabPanel.vue'
import BaseTabPanels from '@/Components/Base/headless/Tab/BaseTabPanels.vue'

defineProps<{
    phases: AcademicLevelsIndexResource
}>()
</script>

<template>
    <base-tab-panels class="px-5 pb-5">
        <base-tab-panel v-for="(phase, key) in phases" :key class="grid grid-cols-12 gap-x-10 gap-y-8">
            <div v-for="level in phase" :key="level" class="col-span-6 md:col-span-4">
                <span class="text-slate-500 rtl:!font-semibold"> {{ level.level }}</span>

                <div class="mt-1.5 flex items-center">
                    <div class="text-base">
                        {{ level.orphans_count }}
                    </div>
                </div>
            </div>
        </base-tab-panel>
    </base-tab-panels>
</template>
