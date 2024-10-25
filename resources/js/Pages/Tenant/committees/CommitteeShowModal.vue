<script lang="ts" setup>
import { useCommitteesStore } from '@/stores/committees'
import { Link } from '@inertiajs/vue3'

import ShowModal from '@/Components/Global/ShowModal.vue'

defineProps<{
    open: boolean
    title: string
}>()

// Define custom event emitter for 'close' event
const emit = defineEmits(['close'])

const committeesStore = useCommitteesStore()
</script>

<template>
    <show-modal :open :title size="lg" @close="emit('close')">
        <template #description>
            <!-- Begin: Name-->
            <div class="col-span-6">
                <h2 class="rtl:font-semibold">{{ $t('validation.attributes.name') }}</h2>

                <h3 class="mt-1 rtl:font-medium">
                    {{ committeesStore.committee.name }}
                </h3>
            </div>
            <!-- End: Name-->

            <!-- Begin: Created At-->
            <div class="col-span-6">
                <h2 class="rtl:font-semibold">{{ $t('validation.attributes.created_at') }}</h2>

                <h3 class="mt-1 rtl:font-medium">
                    {{ committeesStore.committee.readable_created_at }}
                </h3>
            </div>
            <!-- End: Created At-->

            <!-- Begin: Creator-->
            <div class="col-span-6">
                <h2 class="rtl:font-semibold">{{ $t('created_by') }}</h2>

                <Link
                    :href="route('tenant.members.index') + `?show=${committeesStore.committee.creator?.id}`"
                    class="mt-1 rtl:font-medium"
                >
                    {{ committeesStore.committee.creator?.name }}
                </Link>
            </div>
            <!-- End: Creator-->

            <!-- Begin: Members Count-->
            <div class="col-span-6">
                <h2 class="rtl:font-semibold">{{ $t('members_count') }}</h2>

                <p class="mt-1 rtl:font-medium">{{ committeesStore.committee.members_count }}</p>
            </div>
            <!-- End: Members Count-->

            <!-- Begin: Description-->
            <div class="col-span-12">
                <h2 class="rtl:font-semibold">{{ $t('validation.attributes.description') }}</h2>

                <p class="mt-1 rtl:font-medium">
                    {{ committeesStore.committee.description }}
                </p>
            </div>
            <!-- End: Description-->
        </template>
    </show-modal>
</template>
