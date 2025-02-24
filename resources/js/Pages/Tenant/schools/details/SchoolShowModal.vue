<script lang="ts" setup>
import { useSchoolsStore } from '@/stores/schools'
import { Link } from '@inertiajs/vue3'

import TheLessonsTable from '@/Pages/Tenant/schools/details/TheLessonsTable.vue'

import ShowModal from '@/Components/Global/ShowModal.vue'

defineProps<{
    open: boolean
    title: string
}>()

// Define custom event emitter for 'close' event
const emit = defineEmits(['close'])

const schoolStore = useSchoolsStore()
</script>

<template>
    <show-modal :open :title size="lg" @close="emit('close')">
        <template #description>
            <!-- Begin: Name-->
            <div class="col-span-6">
                <h2 class="rtl:font-semibold">{{ $t('school_name') }}</h2>

                <h3 class="mt-1 rtl:font-medium">
                    {{ schoolStore.school.name }}
                </h3>
            </div>
            <!-- End: Name-->

            <!-- Begin: Created At-->
            <div class="col-span-6">
                <h2 class="rtl:font-semibold">{{ $t('validation.attributes.created_at') }}</h2>

                <h3 class="mt-1 rtl:font-medium">
                    {{ schoolStore.school.readable_created_at }}
                </h3>
            </div>
            <!-- End: Created At-->

            <!-- Begin: lessons count-->
            <div class="col-span-6">
                <h2 class="rtl:font-semibold">{{ $t('lessons_count') }}</h2>

                <h3 class="mt-1 rtl:font-medium">
                    {{ schoolStore.school.lessons_count }}
                </h3>
            </div>
            <!-- End: lessons count-->

            <!-- Begin: Quota-->
            <div class="col-span-6">
                <h2 class="rtl:font-semibold">{{ $t('quota_total') }}</h2>

                <h3 class="mt-1 rtl:font-medium">
                    {{ schoolStore.school.quota }}
                </h3>
            </div>
            <!-- End: Quota-->

            <!-- Begin: Creator-->
            <div class="col-span-6">
                <h2 class="rtl:font-semibold">{{ $t('created_by') }}</h2>

                <Link
                    :href="route('tenant.members.index') + `?show=${schoolStore.school.creator?.id}`"
                    class="mt-1 rtl:font-medium"
                >
                    {{ schoolStore.school.creator?.name }}
                </Link>
            </div>
            <!-- End: Creator-->

            <the-lessons-table :lessons="schoolStore.school.lessons"></the-lessons-table>
        </template>
    </show-modal>
</template>
