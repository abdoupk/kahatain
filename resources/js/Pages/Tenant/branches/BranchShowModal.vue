<script lang="ts" setup>
import { useBranchesStore } from '@/stores/branches'
import { Link } from '@inertiajs/vue3'

import ShowModal from '@/Components/Global/ShowModal.vue'

defineProps<{
    open: boolean
    title: string
}>()

// Define custom event emitter for 'close' event
const emit = defineEmits(['close'])

const branchesStore = useBranchesStore()
</script>

<template>
    <show-modal :open :title size="lg" @close="emit('close')">
        <template #description>
            <!-- Begin: Name-->
            <div class="col-span-6">
                <h2 class="rtl:font-semibold">{{ $t('validation.attributes.name') }}</h2>

                <h3 class="mt-1 rtl:font-medium">
                    {{ branchesStore.branch.name }}
                </h3>
            </div>
            <!-- End: Name-->

            <!-- Begin: President-->
            <div class="col-span-6">
                <h2 class="rtl:font-semibold">{{ $t('branch_president') }}</h2>

                <Link
                    :href="route('tenant.members.index') + `?show=${branchesStore.branch.president?.id}`"
                    class="mt-1 rtl:font-medium"
                >
                    {{ branchesStore.branch.president?.name }}
                </Link>
            </div>
            <!-- End: President-->

            <!-- Begin: Families Count-->
            <div class="col-span-6">
                <h2 class="rtl:font-semibold">{{ $t('families_count') }}</h2>

                <h3 class="mt-1 rtl:font-medium">
                    {{ branchesStore.branch.families_count }}
                </h3>
            </div>
            <!-- End: Families Count-->

            <!-- Begin: City-->
            <div class="col-span-6">
                <h2 class="rtl:font-semibold">{{ $t('location') }}</h2>

                <h3 class="mt-1 rtl:font-medium">
                    {{ branchesStore.branch.city_name }}
                </h3>
            </div>
            <!-- End: City-->

            <!-- Begin: Created At-->
            <div class="col-span-6">
                <h2 class="rtl:font-semibold">{{ $t('validation.attributes.created_at') }}</h2>

                <h3 class="mt-1 rtl:font-medium">
                    {{ branchesStore.branch.readable_created_at }}
                </h3>
            </div>
            <!-- End: Created At-->

            <!-- Begin: Creator-->
            <div class="col-span-6">
                <h2 class="rtl:font-semibold">{{ $t('created_by') }}</h2>

                <Link
                    :href="route('tenant.members.index') + `?show=${branchesStore.branch.creator?.id}`"
                    class="mt-1 rtl:font-medium"
                >
                    {{ branchesStore.branch.creator?.name }}
                </Link>
            </div>
            <!-- End: Creator-->
        </template>
    </show-modal>
</template>
