<script lang="ts" setup>
import type { OrphanUpdateFormType } from '@/types/orphans'

import { Head } from '@inertiajs/vue3'
import { defineAsyncComponent, ref } from 'vue'

import TheLayout from '@/Layouts/TheLayout.vue'

import TheContentLoader from '@/Components/Global/theContentLoader.vue'

import { $t } from '@/utils/i18n'

const GeneralInformation = defineAsyncComponent(() => import('@/Pages/Tenant/orphans/edit/GeneralInformation.vue'))

defineOptions({
    layout: TheLayout
})

const props = defineProps<{
    orphan: OrphanUpdateFormType
}>()

const orphan = ref(props.orphan)
</script>

<template>
    <Head :title="$t('orphan profile')"></Head>

    <suspense>
        <div>
            <div class="intro-y mt-8 flex items-center">
                <h2 class="me-auto text-lg font-medium ltr:capitalize">
                    {{ $t('orphan profile') }}
                </h2>
            </div>

            <div class="mt-5 grid grid-cols-12 gap-6">
                <div class="col-span-12 lg:col-span-8 2xl:col-span-9">
                    <div class="grid grid-cols-12 gap-6">
                        <general-information :orphan @orphan-updated="orphan = $event"></general-information>
                    </div>
                </div>
            </div>
        </div>

        <template #fallback>
            <the-content-loader></the-content-loader>
        </template>
    </suspense>
</template>
