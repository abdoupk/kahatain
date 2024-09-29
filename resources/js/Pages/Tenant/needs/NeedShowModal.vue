<script lang="ts" setup>
import { useNeedsStore } from '@/stores/needs'
import { Link } from '@inertiajs/vue3'
import { computed } from 'vue'

import ShowModal from '@/Components/Global/ShowModal.vue'

defineProps<{
    open: boolean
    title: string
}>()

// Define custom event emitter for 'close' event
const emit = defineEmits(['close'])

const needsStore = useNeedsStore()

const needableUrl = computed(() => {
    if (needsStore.need.needable) {
        if (needsStore.need.needable.type === 'orphan') {
            return route('tenant.orphans.show', needsStore.need.needable.id)
        } else {
            return route('tenant.sponsors.show', needsStore.need.needable.id)
        }
    }

    return '#'
})
</script>

<template>
    <show-modal :open :title size="lg" @close="emit('close')">
        <template #description>
            <!-- Begin: Subject-->
            <div class="col-span-6">
                <h2 class="rtl:font-semibold">{{ $t('validation.attributes.subject') }}</h2>

                <h3 class="mt-1 rtl:font-medium">
                    {{ needsStore.need.subject }}
                </h3>
            </div>
            <!-- End: Subject-->

            <!-- Begin: Needable-->
            <div class="col-span-6">
                <h2 class="rtl:font-semibold">{{ $t('the_requester') }}</h2>

                <h3 class="mt-1 rtl:font-medium">
                    {{ needsStore.need.needable?.name }}

                    <Link :href="needableUrl" class="mt-1 rtl:font-medium">
                        {{ needsStore.need.needable?.name }} ({{ $t(`needs.${needsStore.need.needable?.type}`) }})
                    </Link>
                </h3>
            </div>
            <!-- End: Needable-->

            <!-- Begin: Status-->
            <div class="col-span-6">
                <h2 class="rtl:font-semibold">{{ $t('validation.attributes.status') }}</h2>

                <h3 class="mt-1 rtl:font-medium">
                    {{ $t(needsStore.need.status) }}
                </h3>
            </div>
            <!-- End: Status-->

            <!-- Begin: Created At-->
            <div class="col-span-6">
                <h2 class="rtl:font-semibold">{{ $t('validation.attributes.created_at') }}</h2>

                <h3 class="mt-1 rtl:font-medium">
                    {{ needsStore.need.readable_created_at }}
                </h3>
            </div>
            <!-- End: Created At-->

            <!-- Begin: Creator-->
            <div class="col-span-6">
                <h2 class="rtl:font-semibold">{{ $t('created_by') }}</h2>

                <Link
                    :href="route('tenant.members.index') + `?show=${needsStore.need.creator?.id}`"
                    class="mt-1 rtl:font-medium"
                >
                    {{ needsStore.need.creator?.name }}
                </Link>
            </div>
            <!-- End: Creator-->

            <!-- Begin: Demand-->
            <div class="col-span-12">
                <h2 class="rtl:font-semibold">{{ $t('the_demand') }}</h2>

                <p class="mt-1 rtl:font-medium">{{ needsStore.need.demand }}</p>
            </div>
            <!-- End: Demand-->

            <!-- Begin: Note-->
            <div class="col-span-12">
                <h2 class="rtl:font-semibold">{{ $t('validation.attributes.note') }}</h2>

                <p class="mt-1 rtl:font-medium">{{ needsStore.need.note }}</p>
            </div>
            <!-- End: Note-->
        </template>
    </show-modal>
</template>
