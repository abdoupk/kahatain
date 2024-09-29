<script lang="ts" setup>
import { useInventoryStore } from '@/stores/inventory'
import { Link } from '@inertiajs/vue3'

import ShowModal from '@/Components/Global/ShowModal.vue'

import { $t } from '@/utils/i18n'

defineProps<{
    open: boolean
    title: string
}>()

// Define custom event emitter for 'close' event
const emit = defineEmits(['close'])

const inventoryStore = useInventoryStore()
</script>

<template>
    <show-modal :open :title size="lg" @close="emit('close')">
        <template #description>
            <!-- Begin: Name-->
            <div class="col-span-6">
                <h2 class="rtl:font-semibold">{{ $t('item_name') }}</h2>

                <h3 class="mt-1 rtl:font-medium">
                    {{ inventoryStore.item.name }}
                </h3>
            </div>
            <!-- End: Name-->

            <!-- Begin: Quantity-->
            <div class="col-span-6">
                <h2 class="rtl:font-semibold">{{ $t('validation.attributes.amount') }}</h2>

                <h3 class="mt-1 rtl:font-medium">{{ inventoryStore.item.qty }} ({{ $t(inventoryStore.item.unit) }})</h3>
            </div>
            <!-- End: Quantity-->

            <!-- Begin: Type-->
            <div v-if="['diapers', 'baby_milk'].includes(inventoryStore.item.type)" class="col-span-6">
                <h2 class="rtl:font-semibold">{{ $t('the_type') }}</h2>

                <h3 class="mt-1 rtl:font-medium">
                    {{ $t(inventoryStore.item.type) }}
                </h3>
            </div>
            <!-- End: Type-->

            <!-- Begin: Created At-->
            <div class="col-span-6">
                <h2 class="rtl:font-semibold">{{ $t('validation.attributes.created_at') }}</h2>

                <h3 class="mt-1 rtl:font-medium">
                    {{ inventoryStore.item.readable_created_at }}
                </h3>
            </div>
            <!-- End: Created At-->

            <!-- Begin: Creator-->
            <div class="col-span-6">
                <h2 class="rtl:font-semibold">{{ $t('created_by') }}</h2>

                <Link
                    :href="route('tenant.members.index') + `?show=${inventoryStore.item.creator?.id}`"
                    class="mt-1 rtl:font-medium"
                >
                    {{ inventoryStore.item.creator?.name }}
                </Link>
            </div>
            <!-- End: Creator-->

            <!-- Begin: Quantity For each Family-->
            <div v-if="!['diapers', 'baby_milk'].includes(inventoryStore.item.type)" class="col-span-6">
                <h2 class="rtl:font-semibold">{{ $t('quantity_for_each_family') }}</h2>

                <p class="mt-1 rtl:font-medium">{{ inventoryStore.item.qty_for_family }}</p>
            </div>
            <!-- End: Quantity For each Family-->

            <!-- Begin: Note-->
            <div class="col-span-12">
                <h2 class="rtl:font-semibold">{{ $t('validation.attributes.note') }}</h2>

                <p class="mt-1 rtl:font-medium">{{ inventoryStore.item.note }}</p>
            </div>
            <!-- End: Note-->
        </template>
    </show-modal>
</template>
