<script lang="ts" setup>
import { useMembersStore } from '@/stores/members'
import { Link } from '@inertiajs/vue3'

import ShowModal from '@/Components/Global/ShowModal.vue'

defineProps<{
    open: boolean
    title: string
}>()

// Define custom event emitter for 'close' event
const emit = defineEmits(['close'])

const membersStore = useMembersStore()
</script>

<template>
    <show-modal :open :title size="lg" @close="emit('close')">
        <template #description>
            <!-- Begin: Name-->
            <div class="col-span-6">
                <h2 class="rtl:font-semibold">{{ $t('validation.attributes.name') }}</h2>

                <h3 class="mt-1 rtl:font-medium">
                    {{ membersStore.member.name }}
                </h3>
            </div>
            <!-- End: Name-->

            <!-- Begin: Email-->
            <div class="col-span-6">
                <h2 class="rtl:font-semibold">{{ $t('validation.attributes.email') }}</h2>

                <h3 class="mt-1 rtl:font-medium">
                    {{ membersStore.member.email }}
                </h3>
            </div>
            <!-- End: Email-->

            <!-- Begin: Phone-->
            <div class="col-span-6">
                <h2 class="rtl:font-semibold">{{ $t('validation.attributes.sponsor.phone_number') }}</h2>

                <h3 class="mt-1 rtl:font-medium">
                    {{ $t(membersStore.member.phone) }}
                </h3>
            </div>
            <!-- End: Phone-->

            <!-- Begin: Created At-->
            <div class="col-span-6">
                <h2 class="rtl:font-semibold">{{ $t('validation.attributes.created_at') }}</h2>

                <h3 class="mt-1 rtl:font-medium">
                    {{ membersStore.member.readable_created_at }}
                </h3>
            </div>
            <!-- End: Created At-->

            <!-- Begin: Creator-->
            <div class="col-span-6">
                <h2 class="rtl:font-semibold">{{ $t('created_by') }}</h2>

                <Link
                    :href="route('tenant.members.index') + `?show=${membersStore.member.creator?.id}`"
                    class="mt-1 rtl:font-medium"
                >
                    {{ membersStore.member.creator?.name }}
                </Link>
            </div>
            <!-- End: Creator-->

            <!-- Begin: Gender-->
            <div class="col-span-6">
                <h2 class="rtl:font-semibold">{{ $t('filters.gender') }}</h2>

                <p class="mt-1 rtl:font-medium">{{ $t(membersStore.member.gender) }}</p>
            </div>
            <!-- End: Gender-->

            <!-- Begin: Roles-->
            <div class="col-span-6">
                <h2 class="rtl:font-semibold">{{ $t('the_roles') }}</h2>

                <p class="mt-1 rtl:font-medium">{{ membersStore.member.readable_roles }}</p>
            </div>
            <!-- End: Roles-->

            <!-- Begin: Qualification-->
            <div class="col-span-6">
                <h2 class="rtl:font-semibold">{{ $t('validation.attributes.qualification') }}</h2>

                <p class="mt-1 rtl:font-medium">{{ membersStore.member.qualification }}</p>
            </div>
            <!-- End: Qualification-->
        </template>
    </show-modal>
</template>
