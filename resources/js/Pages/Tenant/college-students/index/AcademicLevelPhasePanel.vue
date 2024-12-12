<script lang="ts" setup>
import { AcademicLevelsIndexResource } from '@/types/lessons'

import { twMerge } from 'tailwind-merge'

import BaseTabPanel from '@/Components/Base/headless/Tab/BaseTabPanel.vue'
import BaseTabPanels from '@/Components/Base/headless/Tab/BaseTabPanels.vue'
import BaseTippy from '@/Components/Base/tippy/BaseTippy.vue'

import { $t } from '@/utils/i18n'

defineProps<{
    phases: AcademicLevelsIndexResource
}>()

const getContentMessage = (percentage: number) => {
    if (percentage === 100) {
        return $t('all_transcripts_for_this_phase_have_been_filled_out')
    } else if (percentage > 50 && percentage < 100) {
        return $t('of_transcripts_for_this_phase_have_been_filled_out', { percentage: String(percentage) })
    } else if (percentage > 0 && percentage < 50) {
        return $t('of_transcripts_for_this_phase_have_not_been_filled_out', { percentage: String(100 - percentage) })
    } else if (percentage === 0) {
        return $t('no_transcripts_have_been_filled_out_for_this_phase')
    }
}
</script>

<template>
    <base-tab-panels class="px-5 pb-5">
        <base-tab-panel v-for="(phase, key) in phases" :key class="grid grid-cols-12 gap-x-10 gap-y-8">
            <div v-for="level in phase" :key="level" class="col-span-12 sm:col-span-6 md:col-span-4">
                <span class="text-slate-500 rtl:!font-semibold"> {{ level.level }}</span>

                <div class="mt-1.5 flex items-center">
                    <div class="text-base">
                        {{ level.orphans_count }}
                    </div>

                    <base-tippy
                        :class="
                            twMerge([
                                level.achievement_percentage === 100 && 'text-success',
                                level.achievement_percentage < 100 &&
                                    level.achievement_percentage > 50 &&
                                    'text-pending',
                                level.achievement_percentage < 50 && 'text-danger'
                            ])
                        "
                        :content="getContentMessage(level.achievement_percentage)"
                        class="ms-2 flex cursor-pointer text-xs font-medium"
                    >
                        {{ level.achievement_percentage }}%
                    </base-tippy>
                </div>
            </div>
        </base-tab-panel>
    </base-tab-panels>
</template>
