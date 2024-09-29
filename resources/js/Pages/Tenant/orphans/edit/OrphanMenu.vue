<script lang="ts" setup>
import type { OrphanUpdateFormType } from '@/types/orphans'

import { useNeedsStore } from '@/stores/needs'
import { Link } from '@inertiajs/vue3'
import { computed, ref } from 'vue'

import NeedCreateUpdateModal from '@/Pages/Tenant/needs/create/NeedCreateUpdateModal.vue'
import MenuLink from '@/Pages/Tenant/orphans/details/MenuLink.vue'

import BaseButton from '@/Components/Base/button/BaseButton.vue'

const props = defineProps<{ orphan: OrphanUpdateFormType }>()

const name = computed(() => {
    return props.orphan.first_name + ' ' + props.orphan.last_name
})

const needsStore = useNeedsStore()

const needCreateModalStatus = ref<boolean>(false)

const showNeedCreateModal = () => {
    needsStore.$reset()

    needsStore.need.needable_type = 'orphan'

    needsStore.need.needable_id = props.orphan.id

    needCreateModalStatus.value = true
}
</script>

<template>
    <!-- BEGIN: Profile Menu -->
    <div class="col-span-12 flex flex-col-reverse lg:col-span-4 lg:block 2xl:col-span-3">
        <div class="intro-y box mt-5 lg:mt-0">
            <div class="relative flex items-center p-5">
                <div class="me-auto ms-4">
                    <div class="text-base font-bold">{{ name }}</div>

                    <Link
                        :href="route('tenant.members.index') + '?show=' + orphan.creator?.id"
                        class="font-semibold text-slate-500"
                    >
                        {{ orphan.creator?.name }}
                    </Link>
                </div>
            </div>

            <div class="border-t border-slate-200/60 p-5 dark:border-darkmode-400">
                <menu-link class="!mt-0" icon="icon-memo-circle-info" view-name="general_information"></menu-link>

                <menu-link icon="icon-couple" view-name="sponsorships_information"></menu-link>
            </div>

            <div class="border-t border-slate-200/60 p-5 dark:border-darkmode-400">
                <menu-link class="!mt-0" icon="icon-books" view-name="academic_achievement"></menu-link>

                <menu-link icon="icon-diploma" view-name="college_achievement"></menu-link>

                <menu-link icon="icon-file-certificate" view-name="vocational_training_achievement"></menu-link>
            </div>

            <div class="flex border-t border-slate-200/60 p-5 dark:border-darkmode-400">
                <base-button class="px-2 py-1" type="button" variant="primary" @click.prevent="showNeedCreateModal">
                    {{ $t('new need') }}
                </base-button>
            </div>
        </div>
    </div>
    <!-- END: Profile Menu -->

    <need-create-update-modal
        :close-only="true"
        :open="needCreateModalStatus"
        @close="needCreateModalStatus = false"
    ></need-create-update-modal>
</template>
