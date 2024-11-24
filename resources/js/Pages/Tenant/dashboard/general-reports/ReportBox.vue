<script lang="ts" setup>
import type { SVGType } from '@/types/types'

import { twMerge } from 'tailwind-merge'
import { computed } from 'vue'

import BaseTippy from '@/Components/Base/tippy/BaseTippy.vue'
import SvgLoader from '@/Components/Global/SvgLoader.vue'

import { $t } from '@/utils/i18n'

interface Props {
    icon: SVGType
    iconColor: 'primary' | 'secondary' | 'success' | 'warning' | 'pending' | 'danger' | 'dark'
    stat: number
    title: string
    percentageDifference: number
}

const props = defineProps<Props>()

const tippyContent = computed(() => {
    return $t('reportTooltip', {
        percentage: Math.abs(props?.percentageDifference).toString(),
        range: props?.percentageDifference > 0 ? $t('higher') : $t('lower')
    })
})
</script>

<template>
    <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
        <div
            :class="[
                'zoom-in relative',
                'before:absolute before:inset-x-0 before:mx-auto before:mt-2.5 before:h-full before:w-[90%] before:rounded-md before:bg-white/60 before:shadow-[0px_3px_5px_#0000000b] before:content-[\'\'] before:dark:bg-darkmode-400/70'
            ]"
        >
            <div class="box p-5">
                <div class="flex">
                    <svg-loader
                        :class="
                            twMerge([
                                iconColor === 'primary' && 'fill-primary dark:fill-current',
                                iconColor === 'secondary' && 'fill-secondary',
                                iconColor === 'success' && 'fill-success',
                                iconColor === 'warning' && 'fill-warning',
                                iconColor === 'pending' && 'fill-pending',
                                iconColor === 'danger' && 'fill-danger',
                                iconColor === 'dark' && 'fill-dark dark:fill-slate-400'
                            ])
                        "
                        :name="icon"
                        class="h-[38px] w-[38px]"
                    ></svg-loader>

                    <div v-if="percentageDifference" class="ms-auto">
                        <base-tippy
                            :class="[percentageDifference > 0 && 'bg-success', percentageDifference < 0 && 'bg-danger']"
                            :content="tippyContent"
                            as="div"
                            class="flex cursor-pointer items-center rounded-full py-[3px] pe-1 ps-2 text-xs font-medium text-white"
                        >
                            {{ Math.abs(percentageDifference) }}%
                            <svg-loader
                                v-if="percentageDifference > 0"
                                class="ms-0.5 h-4 w-4 rotate-180"
                                name="icon-chevron-down"
                            ></svg-loader>

                            <svg-loader v-else class="ms-0.5 h-4 w-4" name="icon-chevron-down"></svg-loader>
                        </base-tippy>
                    </div>
                </div>

                <div class="mt-6 text-3xl font-medium leading-8">{{ stat }}</div>

                <div class="mt-1 text-base text-slate-500">{{ title }}</div>
            </div>
        </div>
    </div>
</template>
