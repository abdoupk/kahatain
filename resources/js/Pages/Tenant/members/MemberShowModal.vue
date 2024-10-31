<script lang="ts" setup>
import { useMembersStore } from '@/stores/members'
import { Link } from '@inertiajs/vue3'

import ShowModal from '@/Components/Global/ShowModal.vue'

import { $t } from '@/utils/i18n'

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
                    v-if="membersStore.member.creator?.id"
                    :href="route('tenant.members.index') + `?show=${membersStore.member.creator?.id}`"
                    class="mt-1 rtl:font-medium"
                >
                    {{ membersStore.member.creator?.name }}
                </Link>

                <span v-else class="mt-1 rtl:font-medium"> - </span>
            </div>
            <!-- End: Creator-->

            <!-- Begin: Gender-->
            <div class="col-span-6">
                <h2 class="rtl:font-semibold">{{ $t('filters.gender') }}</h2>

                <p class="mt-1 rtl:font-medium">{{ $t(membersStore.member.gender) }}</p>
            </div>
            <!-- End: Gender-->

            <!-- Begin: Gender-->
            <div class="col-span-6">
                <h2 class="rtl:font-semibold">{{ $t('academic_level') }}</h2>

                <p class="mt-1 rtl:font-medium">{{ $t(membersStore.member.academic_level) }}</p>
            </div>
            <!-- End: Gender-->

            <!-- Begin: Roles-->
            <div class="col-span-6">
                <h2 class="rtl:font-semibold">{{ $t('the_roles') }}</h2>

                <p class="mt-1 rtl:font-medium">{{ membersStore.member.readable_roles }}</p>
            </div>
            <!-- End: Roles-->

            <!-- Begin: Committees-->
            <div class="col-span-6">
                <h2 class="rtl:font-semibold">{{ $t('the_committees') }}</h2>

                <p class="mt-1 rtl:font-medium">{{ membersStore.member.readable_committees }}</p>
            </div>
            <!-- End: Committees-->

            <!-- Begin: Competences-->
            <div class="col-span-6">
                <h2 class="rtl:font-semibold">{{ $t('competences') }}</h2>

                <p class="mt-1 rtl:font-medium">{{ membersStore.member.readable_competences }}</p>
            </div>
            <!-- End: Competences-->

            <!-- Begin: Workplace-->
            <div class="col-span-6">
                <h2 class="rtl:font-semibold">{{ $t('validation.attributes.workplace') }}</h2>

                <p class="mt-1 rtl:font-medium">{{ membersStore.member.workplace }}</p>
            </div>
            <!-- End: Workplace-->

            <!-- Begin: Function-->
            <div class="col-span-6">
                <h2 class="rtl:font-semibold">{{ $t('validation.attributes.sponsor.function') }}</h2>

                <p class="mt-1 rtl:font-medium">{{ membersStore.member.function }}</p>
            </div>
            <!-- End: Function-->

            <!-- Begin: Branch-->
            <div class="col-span-6">
                <h2 class="rtl:font-semibold">{{ $t('validation.attributes.branch_id') }}</h2>

                <Link
                    :href="route('tenant.branches.index') + `?show=${membersStore.member.branch?.id}`"
                    class="mt-1 rtl:font-medium"
                    >{{ membersStore.member.branch?.name }}
                </Link>
            </div>
            <!-- End: Branch-->

            <!-- Begin: Zone-->
            <div class="col-span-6">
                <h2 class="rtl:font-semibold">{{ $t('validation.attributes.zone_id') }}</h2>

                <Link
                    :href="route('tenant.zones.index') + `?show=${membersStore.member.zone.id}`"
                    class="mt-1 rtl:font-medium"
                    >{{ membersStore.member.zone.name }}
                </Link>
            </div>
            <!-- End: Zone-->

            <!-- Begin: Address-->
            <div class="col-span-6">
                <h2 class="rtl:font-semibold">{{ $t('validation.attributes.address') }}</h2>

                <p class="mt-1 rtl:font-medium">{{ membersStore.member.address }}</p>
            </div>
            <!-- End: Address-->
        </template>
    </show-modal>
</template>
