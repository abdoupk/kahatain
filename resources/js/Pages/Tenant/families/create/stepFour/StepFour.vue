<script lang="ts" setup>
import type { CreateFamilyStepProps } from '@/types/types'

import BaseTab from '@/Components/Base/headless/Tab/BaseTab.vue'
import BaseTabButton from '@/Components/Base/headless/Tab/BaseTabButton.vue'
import BaseTabGroup from '@/Components/Base/headless/Tab/BaseTabGroup.vue'
import BaseTabList from '@/Components/Base/headless/Tab/BaseTabList.vue'
import BaseTabPanel from '@/Components/Base/headless/Tab/BaseTabPanel.vue'
import BaseTabPanels from '@/Components/Base/headless/Tab/BaseTabPanels.vue'
import { computed } from 'vue'
import { checkErrors } from '@/utils/helper'
import SvgLoader from '@/Components/SvgLoader.vue'

const props = defineProps<CreateFamilyStepProps>()

const housingErrors = computed(() => {
    return checkErrors('^housing', props?.form?.errors)
})

const otherPropertiesErrors = computed(() => {
    return checkErrors('other_properties$', props?.form?.errors)
})

const furnishingsErrors = computed(() => {
    return checkErrors('^furnishings', props?.form?.errors)
})
</script>

<template>
    <div
        v-if="currentStep === 4"
        class="mt-10 border-t border-slate-200/60 px-5 pt-10 dark:border-darkmode-400 sm:px-20"
    >
        <div class="text-lg font-medium hidden lg:block mb-6">
            {{ $t('families.create_family.stepFour') }}
        </div>

        <base-tab-group class="mt-5">
            <base-tab-list class="md:flex" variant="link-tabs">
                <base-tab>
                    <base-tab-button as="button" class="w-full py-2" type="button">
                        {{ $t('housing information') }}

                        <svg-loader
                            v-if="housingErrors"
                            class="fill-red-500 inline ms-4"
                            name="icon-circle-exclamation"
                        ></svg-loader>
                    </base-tab-button>
                </base-tab>

                <base-tab>
                    <base-tab-button as="button" class="w-full py-2" type="button">
                        {{ $t('furnishing information') }}

                        <svg-loader
                            v-if="furnishingsErrors"
                            class="fill-red-500 inline ms-4"
                            name="icon-circle-exclamation"
                        ></svg-loader>
                    </base-tab-button>
                </base-tab>

                <base-tab>
                    <base-tab-button as="button" class="w-full py-2" type="button">
                        {{ $t('other_properties') }}

                        <svg-loader
                            v-if="otherPropertiesErrors"
                            class="fill-red-500 inline ms-4"
                            name="icon-circle-exclamation"
                        ></svg-loader>
                    </base-tab-button>
                </base-tab>
            </base-tab-list>

            <base-tab-panels>
                <base-tab-panel class="p-5">
                    <slot name="housingForm"></slot>
                </base-tab-panel>

                <base-tab-panel class="p-5">
                    <slot name="furnishingForm"></slot>
                </base-tab-panel>

                <base-tab-panel class="p-5">
                    <slot name="otherPropertiesForm"></slot>
                </base-tab-panel>
            </base-tab-panels>
        </base-tab-group>

        <slot></slot>
    </div>
</template>
