<script lang="ts" setup>
import type { SponsorUpdateFormType } from '@/types/sponsors'

import { useNeedsStore } from '@/stores/needs'
import { Link } from '@inertiajs/vue3'
import { computed, ref } from 'vue'

import NeedCreateUpdateModal from '@/Pages/Tenant/needs/create/NeedCreateUpdateModal.vue'
import MenuLink from '@/Pages/Tenant/sponsors/details/MenuLink.vue'

import BaseButton from '@/Components/Base/button/BaseButton.vue'

const props = defineProps<{ sponsor: SponsorUpdateFormType }>()

const name = computed(() => {
    return props.sponsor.first_name + ' ' + props.sponsor.last_name
})

const needsStore = useNeedsStore()

const needCreateModalStatus = ref<boolean>(false)

const showNeedCreateModal = () => {
    needsStore.$reset()

    needsStore.need.needable_type = 'sponsor'

    needsStore.need.needable_id = props.sponsor.id

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
                        :href="route('tenant.members.index') + '?show=' + sponsor.creator?.id"
                        class="font-semibold text-slate-500"
                    >
                        {{ sponsor.creator?.name }}
                    </Link>
                </div>
            </div>

            <div class="border-t border-slate-200/60 p-5 dark:border-darkmode-400">
                <menu-link class="!mt-0" icon="icon-memo-circle-info" view-name="general_information"></menu-link>

                <menu-link icon="icon-couple" view-name="incomes_information"></menu-link>

                <!--                <menu-link icon="icon-couple" view-name="sponsorships_information"></menu-link>-->
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
