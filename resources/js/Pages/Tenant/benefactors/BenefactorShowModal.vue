<script lang="ts" setup>
import { useBenefactorsStore } from '@/stores/benefactors'
import { Link } from '@inertiajs/vue3'
import { defineAsyncComponent } from 'vue'

import ShowModal from '@/Components/Global/ShowModal.vue'

import { $t } from '@/utils/i18n'

const TheSponsorshipsTable = defineAsyncComponent(() => import('@/Pages/Tenant/benefactors/TheSponsorshipsTable.vue'))

defineProps<{
    open: boolean
    title: string
}>()

// Define custom event emitter for 'close' event
const emit = defineEmits(['close'])

const benefactorsStore = useBenefactorsStore()
</script>

<template>
    <show-modal :open :title size="xl" @close="emit('close')">
        <template #description>
            <!-- Begin: Name-->
            <div class="col-span-6">
                <h2 class="rtl:font-semibold">{{ $t('validation.attributes.name') }}</h2>

                <h3 class="mt-1 rtl:font-medium">
                    {{ benefactorsStore.benefactor.name }}
                </h3>
            </div>
            <!-- End: Name-->

            <!-- Begin: Created At-->
            <div class="col-span-6">
                <h2 class="rtl:font-semibold">{{ $t('validation.attributes.created_at') }}</h2>

                <h3 class="mt-1 rtl:font-medium">
                    {{ benefactorsStore.benefactor.readable_created_at }}
                </h3>
            </div>
            <!-- End: Created At-->

            <!-- Begin: Creator-->
            <div class="col-span-6">
                <h2 class="rtl:font-semibold">{{ $t('created_by') }}</h2>

                <Link
                    :href="route('tenant.members.index') + `?show=${benefactorsStore.benefactor.creator?.id}`"
                    class="mt-1 rtl:font-medium"
                >
                    {{ benefactorsStore.benefactor.creator?.name }}
                </Link>
            </div>
            <!-- End: Creator-->

            <!-- Begin: Address-->
            <div class="col-span-12 sm:col-span-6">
                <h2 class="rtl:font-semibold">{{ $t('validation.attributes.address') }}</h2>

                <p class="mt-1 rtl:font-medium">
                    {{ benefactorsStore.benefactor.address }}
                </p>
            </div>
            <!-- End: Address-->

            <!-- Begin: Sponsorships-->
            <the-sponsorships-table :sponsorships="benefactorsStore.benefactor.sponsorships" />
            <!-- End: Sponsorships-->
        </template>
    </show-modal>
</template>
