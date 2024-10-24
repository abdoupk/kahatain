<script lang="ts" setup>
import { useZonesStore } from '@/stores/zones'
import { Link } from '@inertiajs/vue3'

import ShowModal from '@/Components/Global/ShowModal.vue'
import { $t } from '@/utils/i18n'

defineProps<{
    open: boolean
    title: string
}>()

// Define custom event emitter for 'close' event
const emit = defineEmits(['close'])

const zonesStore = useZonesStore()
</script>

<template>
    <show-modal :open :title size="lg" @close="emit('close')">
        <template #description>
            <!-- Begin: Name-->
            <div class="col-span-6">
                <h2 class="rtl:font-semibold">{{ $t('validation.attributes.name') }}</h2>

                <h3 class="mt-1 rtl:font-medium">
                    {{ zonesStore.zone.name }}
                </h3>
            </div>
            <!-- End: Name-->

            <!-- Begin: Created At-->
            <div class="col-span-6">
                <h2 class="rtl:font-semibold">{{ $t('validation.attributes.created_at') }}</h2>

                <h3 class="mt-1 rtl:font-medium">
                    {{ zonesStore.zone.readable_created_at }}
                </h3>
            </div>
            <!-- End: Created At-->

            <!-- Begin: Creator-->
            <div class="col-span-6">
                <h2 class="rtl:font-semibold">{{ $t('created_by') }}</h2>

                <Link
                    :href="route('tenant.members.index') + `?show=${zonesStore.zone.creator?.id}`"
                    class="mt-1 rtl:font-medium"
                >
                    {{ zonesStore.zone.creator?.name }}
                </Link>
            </div>
            <!-- End: Creator-->

            <!-- Begin: Families Count-->
            <div class="col-span-6">
                <h2 class="rtl:font-semibold">{{ $t('families_count') }}</h2>

                <p class="mt-1 rtl:font-medium">{{ zonesStore.zone.families_count }}</p>
            </div>
            <!-- End: Families Count-->

            <!-- Begin: Members Count-->
            <div class="col-span-6">
                <h2 class="rtl:font-semibold">{{ $t('members_count') }}</h2>

                <p class="mt-1 rtl:font-medium">{{ zonesStore.zone.members_count }}</p>
            </div>
            <!-- End: Members Count-->

            <!-- Begin: Description-->
            <div class="col-span-12">
                <h2 class="rtl:font-semibold">{{ $t('neighborhoods') }}</h2>

                <p class="mt-1 rtl:font-medium">
                    {{ zonesStore.zone.description }}
                </p>
            </div>
            <!-- End: Description-->
        </template>
    </show-modal>
</template>
