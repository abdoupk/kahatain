<script lang="ts" setup>
import type { FamilyShowType } from '@/types/families'
import { PaginationData } from '@/types/types'

import { Head } from '@inertiajs/vue3'
import { defineAsyncComponent, provide, ref } from 'vue'

import TheLayout from '@/Layouts/TheLayout.vue'

import HistoryIndexPage from '@/Pages/Tenant/families/details/history/HistoryIndexPage.vue'

import TheContentLoader from '@/Components/Global/theContentLoader.vue'

import { $t } from '@/utils/i18n'

const FamilyMenu = defineAsyncComponent(() => import('@/Pages/Tenant/families/details/FamilyMenu.vue'))

const TheGeneralInformation = defineAsyncComponent(
    () => import('@/Pages/Tenant/families/details/TheGeneralInformation.vue')
)

const TheHousingInformation = defineAsyncComponent(
    () => import('@/Pages/Tenant/families/details/TheHousingInformation.vue')
)

const TheOrphansInformation = defineAsyncComponent(
    () => import('@/Pages/Tenant/families/details/TheOrphansInformation.vue')
)

const TheReport = defineAsyncComponent(() => import('@/Pages/Tenant/families/details/TheReport.vue'))

const TheSecondSponsorInformation = defineAsyncComponent(
    () => import('@/Pages/Tenant/families/details/TheSecondSponsorInformation.vue')
)

const TheSponsorInformation = defineAsyncComponent(
    () => import('@/Pages/Tenant/families/details/TheSponsorInformation.vue')
)

const TheSpouseInformation = defineAsyncComponent(
    () => import('@/Pages/Tenant/families/details/TheSpouseInformation.vue')
)

defineOptions({
    layout: TheLayout
})

defineProps<{
    family: FamilyShowType
    archives: PaginationData<unknown>
    needs: PaginationData<unknown>
}>()

const view = ref('general_information')

function updateView(newValue: string) {
    view.value = newValue
}

provide('familyDetailView', { view, updateView })
</script>

<template>
    <Head :title="$t('family details')"></Head>

    <suspense>
        <div>
            <div class="intro-y mt-8 flex items-center">
                <h2 class="me-auto text-lg font-medium ltr:capitalize">{{ $t('family details') }}</h2>
            </div>

            <div class="mt-5 grid grid-cols-12 gap-6">
                <family-menu :family></family-menu>

                <div class="col-span-12 lg:col-span-8 2xl:col-span-9">
                    <div class="grid grid-cols-12 gap-6">
                        <the-general-information
                            v-if="view === 'general_information'"
                            :family
                        ></the-general-information>

                        <the-sponsor-information
                            v-if="view === 'sponsor_information'"
                            :sponsor="family.sponsor"
                        ></the-sponsor-information>

                        <the-housing-information
                            v-if="view === 'housing_information'"
                            :furnishings="family.furnishings"
                            :housing="family.housing"
                        ></the-housing-information>

                        <the-second-sponsor-information
                            v-if="view === 'second_sponsor_information'"
                            :second-sponsor="family.second_sponsor"
                        ></the-second-sponsor-information>

                        <the-orphans-information
                            v-if="view === 'orphans_information'"
                            :orphans="family.orphans"
                        ></the-orphans-information>

                        <the-report v-if="view === 'the_report'" :preview="family.preview"></the-report>

                        <the-spouse-information
                            v-if="view === 'spouse_information'"
                            :deceased="family.deceased"
                        ></the-spouse-information>
                    </div>

                    <history-index-page
                        v-if="view === 'family_benefit_history'"
                        :archives
                        :family-id="family.id"
                        :needs
                    ></history-index-page>
                </div>
            </div>
        </div>

        <template #fallback>
            <the-content-loader></the-content-loader>
        </template>
    </suspense>
</template>
