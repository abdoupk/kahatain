<script lang="ts" setup>
import type { CreateFamilyStepProps } from '@/types/types'

import { useCreateFamilyStore } from '@/stores/create-family'
import { computed } from 'vue'

import IncomeForm from '@/Pages/Tenant/families/create/stepTwo/IncomeForm.vue'
import SecondSponsorForm from '@/Pages/Tenant/families/create/stepTwo/SecondSponsorForm.vue'
import SponsorForm from '@/Pages/Tenant/families/create/stepTwo/SponsorForm.vue'
import SpouseForm from '@/Pages/Tenant/families/create/stepTwo/SpouseForm.vue'

import BaseTab from '@/Components/Base/headless/Tab/BaseTab.vue'
import BaseTabButton from '@/Components/Base/headless/Tab/BaseTabButton.vue'
import BaseTabGroup from '@/Components/Base/headless/Tab/BaseTabGroup.vue'
import BaseTabList from '@/Components/Base/headless/Tab/BaseTabList.vue'
import BaseTabPanel from '@/Components/Base/headless/Tab/BaseTabPanel.vue'
import BaseTabPanels from '@/Components/Base/headless/Tab/BaseTabPanels.vue'
import SvgLoader from '@/Components/SvgLoader.vue'

import { checkErrors } from '@/utils/helper'

const props = defineProps<CreateFamilyStepProps>()

const createFamilyStore = useCreateFamilyStore()

const sponsorErrors = computed(() => {
    return checkErrors('^sponsor.+', props?.form?.errors)
})

const secondSponsorErrors = computed(() => {
    return checkErrors('^second_sponsor', props?.form?.errors)
})

const incomeErrors = computed(() => {
    return checkErrors('^income', props?.form?.errors)
})

const spouseErrors = computed(() => {
    return checkErrors('^deceased', props?.form?.errors)
})

const handleTabChange = (index) => {
    createFamilyStore.tab_index = index
}
</script>

<template>
    <div
        v-if="createFamilyStore.current_step === 2"
        class="mt-10 border-t border-slate-200/60 px-5 pt-10 dark:border-darkmode-400 sm:px-20"
    >
        <div class="mb-6 hidden text-lg lg:block rtl:font-bold">
            {{ $t('families.create_family.stepTwo') }}
        </div>

        <base-tab-group :selectedIndex="createFamilyStore.tab_index" class="mt-5" @change="handleTabChange">
            <base-tab-list class="md:flex" variant="link-tabs">
                <base-tab>
                    <base-tab-button as="button" class="w-full py-2" type="button">
                        {{ $t('sponsor information') }}

                        <svg-loader
                            v-if="sponsorErrors"
                            class="ms-4 inline fill-red-500"
                            name="icon-circle-exclamation"
                        ></svg-loader>
                    </base-tab-button>
                </base-tab>
                <base-tab>
                    <base-tab-button as="button" class="w-full py-2" type="button">
                        {{ $t('income information') }}

                        <svg-loader
                            v-if="incomeErrors"
                            class="ms-4 inline fill-red-500"
                            name="icon-circle-exclamation"
                        ></svg-loader>
                    </base-tab-button>
                </base-tab>

                <base-tab>
                    <base-tab-button as="button" class="w-full py-2" type="button">
                        {{ $t('second sponsor information') }}

                        <svg-loader
                            v-if="secondSponsorErrors"
                            class="ms-4 inline fill-red-500"
                            name="icon-circle-exclamation"
                        ></svg-loader>
                    </base-tab-button>
                </base-tab>

                <base-tab>
                    <base-tab-button as="button" class="w-full py-2" type="button">
                        {{ $t('spouse information') }}

                        <svg-loader
                            v-if="spouseErrors"
                            class="ms-4 inline fill-red-500"
                            name="icon-circle-exclamation"
                        ></svg-loader>
                    </base-tab-button>
                </base-tab>
            </base-tab-list>
            <base-tab-panels>
                <base-tab-panel class="p-5">
                    <sponsor-form :form></sponsor-form>
                </base-tab-panel>

                <base-tab-panel class="p-5">
                    <income-form :form></income-form>
                </base-tab-panel>

                <base-tab-panel class="p-5">
                    <second-sponsor-form :form></second-sponsor-form>
                </base-tab-panel>

                <base-tab-panel class="p-5">
                    <spouse-form :form></spouse-form>
                </base-tab-panel>
            </base-tab-panels>
        </base-tab-group>

        <slot></slot>
    </div>
</template>
