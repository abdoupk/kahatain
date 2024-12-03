<script lang="ts" setup>
import type { OrphanShowType } from '@/types/orphans'

import { Head } from '@inertiajs/vue3'
import { defineAsyncComponent, provide, ref } from 'vue'

import TheLayout from '@/Layouts/TheLayout.vue'

import TheContentLoader from '@/Components/Global/theContentLoader.vue'

import { $t } from '@/utils/i18n'

const GeneralInformation = defineAsyncComponent(() => import('@/Pages/Tenant/orphans/details/GeneralInformation.vue'))

const OrphanMenu = defineAsyncComponent(() => import('@/Pages/Tenant/orphans/details/OrphanMenu.vue'))

const SponsorshipsInformation = defineAsyncComponent(
    () => import('@/Pages/Tenant/orphans/details/SponsorshipsInformation.vue')
)

defineOptions({
    layout: TheLayout
})

defineProps<{
    orphan: OrphanShowType
}>()

const view = ref('general_information')

function updateView(newValue: string) {
    view.value = newValue
}

provide('orphanDetailView', { view, updateView })
</script>

<template>
    <Head :title="$t('orphan details')"></Head>

    <suspense>
        <div>
            <div class="intro-y mt-8 flex items-center">
                <h2 class="me-auto text-lg font-medium ltr:capitalize">
                    {{ $t('orphan details') }}
                </h2>
            </div>

            <div class="mt-5 grid grid-cols-12 gap-6">
                <orphan-menu :orphan></orphan-menu>

                <div class="col-span-12 lg:col-span-8 2xl:col-span-9">
                    <div class="grid grid-cols-12 gap-6">
                        <general-information v-if="view === 'general_information'" :orphan></general-information>

                        <sponsorships-information
                            v-if="view === 'sponsorships_information'"
                            :orphan
                        ></sponsorships-information>
                    </div>
                </div>
            </div>
        </div>

        <template #fallback>
            <the-content-loader></the-content-loader>
        </template>
    </suspense>
</template>
