<script lang="ts" setup>
import type { SponsorShowType } from '@/types/sponsors'

import { useNeedsStore } from '@/stores/needs'
import { Link } from '@inertiajs/vue3'
import { ref } from 'vue'

import NeedCreateUpdateModal from '@/Pages/Tenant/needs/create/NeedCreateUpdateModal.vue'
import MenuLink from '@/Pages/Tenant/sponsors/details/MenuLink.vue'

import BaseButton from '@/Components/Base/button/BaseButton.vue'
import TheAvatar from '@/Components/Global/TheAvatar.vue'
import SvgLoader from '@/Components/SvgLoader.vue'

import { hasPermission } from '@/utils/helper'

const props = defineProps<{ sponsor: SponsorShowType }>()

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
                <div class="image-fit h-12 w-12">
                    <img v-if="sponsor.photo" :src="sponsor.photo" alt="" class="rounded-full" />
                    <the-avatar v-else :gender="sponsor.gender" :name="sponsor.name"></the-avatar>
                </div>

                <div class="me-auto ms-4">
                    <div class="text-base font-bold">{{ sponsor.name }}</div>

                    <Link
                        :href="route('tenant.members.index') + '?show=' + sponsor.creator?.id"
                        class="font-semibold text-slate-500"
                    >
                        {{ sponsor.creator?.name }}
                    </Link>
                </div>

                <Link v-if="hasPermission('edit_sponsors')" :href="route('tenant.sponsors.edit', sponsor.id)">
                    <svg-loader class="inline h-4 w-4" name="icon-pen"></svg-loader>

                    <span class="ms-1 rtl:!font-semibold"> {{ $t('edit') }}</span>
                </Link>
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
