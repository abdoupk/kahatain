<script lang="ts" setup>
import type { FamilyEditType } from '@/types/families'

import { Head } from '@inertiajs/vue3'
import { defineAsyncComponent, provide, ref } from 'vue'

import TheLayout from '@/Layouts/TheLayout.vue'

import TheContentLoader from '@/Components/Global/theContentLoader.vue'

import { $t } from '@/utils/i18n'

const FamilyMenu = defineAsyncComponent(() => import('@/Pages/Tenant/families/edit/FamilyMenu.vue'))

const TheFamilySponsorship = defineAsyncComponent(() => import('@/Pages/Tenant/families/edit/TheFamilySponsorship.vue'))

const TheGeneralInformation = defineAsyncComponent(
    () => import('@/Pages/Tenant/families/edit/TheGeneralInformation.vue')
)

const TheHousingInformation = defineAsyncComponent(
    () => import('@/Pages/Tenant/families/edit/housing/TheHousingInformation.vue')
)

const TheReport = defineAsyncComponent(() => import('@/Pages/Tenant/families/edit/TheReport.vue'))

const TheSecondSponsorInformation = defineAsyncComponent(
    () => import('@/Pages/Tenant/families/edit/TheSecondSponsorInformation.vue')
)

const TheSpouseInformation = defineAsyncComponent(() => import('@/Pages/Tenant/families/edit/TheSpouseInformation.vue'))

defineOptions({
    layout: TheLayout
})

defineProps<{ family: FamilyEditType }>()

const view = ref('general_information')

function updateView(newValue: string) {
    view.value = newValue
}

provide('familyEditView', { view, updateView })
</script>

<template>
    <Head :title="$t('family edit')"></Head>

    <suspense>
        <div>
            <div class="intro-y mt-8 flex items-center">
                <h2 class="me-auto text-lg font-medium ltr:capitalize">{{ $t('family edit') }}</h2>
            </div>

            <div class="mt-5 grid grid-cols-12 gap-6">
                <family-menu :family></family-menu>

                <div class="col-span-12 lg:col-span-8 2xl:col-span-9">
                    <div class="grid grid-cols-12 gap-6">
                        <the-general-information
                            v-if="view === 'general_information'"
                            :family
                        ></the-general-information>

                        <the-housing-information
                            v-if="view === 'housing_information'"
                            :furnishings="family.furnishings"
                            :housing="{ ...family.housing, family_id: family.id }"
                        ></the-housing-information>

                        <the-second-sponsor-information
                            v-if="view === 'second_sponsor_information'"
                            :second-sponsor="{ ...family.second_sponsor, family_id: family.id }"
                        ></the-second-sponsor-information>

                        <the-report
                            v-if="view === 'the_report'"
                            :preview="{ ...family.preview, family_id: family.id }"
                        ></the-report>

                        <the-family-sponsorship
                            v-if="view === 'family_sponsorship'"
                            :sponsorships="{ ...family.family_sponsorships, family_id: family.id }"
                        ></the-family-sponsorship>

                        <template v-for="spouse in family.deceased" :key="spouse.id">
                            <the-spouse-information
                                v-if="view === 'spouse_information'"
                                :spouse="{ ...spouse, family_id: family.id }"
                            ></the-spouse-information>
                        </template>
                    </div>
                </div>
            </div>
        </div>

        <template #fallback>
            <the-content-loader></the-content-loader>
        </template>
    </suspense>
</template>
