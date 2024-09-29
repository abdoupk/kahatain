<script lang="ts" setup>
import type { FamilyEditType } from '@/types/families'

import { useNeedsStore } from '@/stores/needs'
import { Link } from '@inertiajs/vue3'
import { ref } from 'vue'

import MenuLink from '@/Pages/Tenant/families/edit/MenuLink.vue'
import NeedCreateUpdateModal from '@/Pages/Tenant/needs/create/NeedCreateUpdateModal.vue'

import BaseButton from '@/Components/Base/button/BaseButton.vue'

defineProps<{ family: FamilyEditType }>()

const needsStore = useNeedsStore()

const needCreateModalStatus = ref<boolean>(false)

const showNeedCreateModal = () => {
    needsStore.$reset()

    needCreateModalStatus.value = true
}
</script>

<template>
    <!-- BEGIN: Profile Menu -->
    <div class="col-span-12 flex flex-col-reverse lg:col-span-4 lg:block 2xl:col-span-3">
        <div class="intro-y box mt-5 lg:mt-0">
            <div class="relative flex items-center p-5">
                <div class="me-auto ms-4">
                    <div class="text-base font-bold">{{ family.name }}</div>
                    <Link
                        :href="route('tenant.members.index') + '?show=' + family.creator?.id"
                        class="font-semibold text-slate-500"
                    >
                        {{ family.creator?.name }}
                    </Link>
                </div>
            </div>

            <div class="border-t border-slate-200/60 p-5 dark:border-darkmode-400">
                <menu-link class="!mt-0" icon="icon-memo-circle-info" view-name="general_information"></menu-link>

                <menu-link icon="icon-couple" view-name="spouse_information"></menu-link>

                <menu-link icon="icon-hands-holding-heart" view-name="second_sponsor_information"></menu-link>

                <menu-link icon="icon-house" view-name="housing_information"></menu-link>
            </div>

            <div class="border-t border-slate-200/60 p-5 dark:border-darkmode-400">
                <menu-link class="!mt-0" icon="icon-file-lines" view-name="the_report"></menu-link>

                <menu-link icon="icon-handshake-angle" view-name="family_sponsorship"></menu-link>
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
        show-the-needable
        @close="needCreateModalStatus = false"
    ></need-create-update-modal>
</template>
