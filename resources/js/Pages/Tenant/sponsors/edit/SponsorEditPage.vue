<script lang="ts" setup>
import type { SponsorUpdateFormType } from '@/types/sponsors'

import { Head } from '@inertiajs/vue3'
import { defineAsyncComponent, provide, ref } from 'vue'

import TheLayout from '@/Layouts/TheLayout.vue'

import TheContentLoader from '@/Components/Global/theContentLoader.vue'

import { $t } from '@/utils/i18n'

const GeneralInformation = defineAsyncComponent(() => import('@/Pages/Tenant/sponsors/edit/GeneralInformation.vue'))

const IncomesInformation = defineAsyncComponent(() => import('@/Pages/Tenant/sponsors/edit/IncomesInformation.vue'))

const SponsorMenu = defineAsyncComponent(() => import('@/Pages/Tenant/sponsors/edit/SponsorMenu.vue'))

const SponsorshipsInformation = defineAsyncComponent(
    () => import('@/Pages/Tenant/sponsors/edit/SponsorshipsInformation.vue')
)

defineOptions({
    layout: TheLayout
})

const props = defineProps<{
    sponsor: SponsorUpdateFormType
}>()

const view = ref('general_information')

const sponsor = ref(props.sponsor)

function updateView(newValue: string) {
    view.value = newValue
}

provide('sponsorDetailView', { view, updateView })
</script>

<template>
    <Head :title="$t('sponsor edit')"></Head>
    <suspense>
        <div>
            <div class="intro-y mt-8 flex items-center">
                <h2 class="me-auto text-lg font-medium ltr:capitalize">
                    {{ $t('sponsor edit') }}
                </h2>
            </div>

            <div class="mt-5 grid grid-cols-12 gap-6">
                <sponsor-menu :sponsor></sponsor-menu>

                <div class="col-span-12 lg:col-span-8 2xl:col-span-9">
                    <div class="grid grid-cols-12 gap-6">
                        <general-information
                            v-if="view === 'general_information'"
                            :sponsor
                            @sponsor-updated="sponsor = $event"
                        ></general-information>

                        <sponsorships-information
                            v-if="view === 'sponsorships_information'"
                            :sponsor
                        ></sponsorships-information>

                        <incomes-information v-if="view === 'incomes_information'" :sponsor></incomes-information>
                    </div>
                </div>
            </div>
        </div>

        <template #fallback>
            <the-content-loader></the-content-loader>
        </template>
    </suspense>
</template>
