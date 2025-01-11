<script lang="ts" setup>
import { BenefactorsIndexResource, IndexParams, PaginationData } from '@/types/types'

import BaseTippy from '@/Components/Base/tippy/BaseTippy.vue'

import { hasPermission } from '@/utils/helper'
import { $t } from '@/utils/i18n'

defineProps<{
    benefactors: PaginationData<BenefactorsIndexResource>
    params: IndexParams
}>()

// eslint-disable-next-line array-element-newline
const emit = defineEmits(['sort', 'showDeleteModal', 'showEditModal', 'showDetailsModal'])
</script>

<template>
    <div class="col-span-12 my-8 grid grid-cols-12 gap-4 @3xl:hidden">
        <div
            v-for="benefactor in benefactors.data"
            :key="benefactor.id"
            class="intro-y !z-10 col-span-12 @xl:col-span-6"
        >
            <div class="box p-5">
                <div class="flex">
                    <div class="me-3 truncate ltr:font-medium rtl:text-lg rtl:font-semibold">
                        {{ benefactor.name }}
                    </div>

                    <base-tippy
                        :content="$t('sponsorships_count')"
                        class="ms-auto flex cursor-pointer items-center truncate rounded-full bg-slate-100 px-2 py-1 text-xs text-slate-500 dark:bg-darkmode-400"
                    >
                        {{ benefactor.sponsorships_count }}
                    </base-tippy>
                </div>

                <div class="mt-4">
                    <div class="flex">
                        <div class="w-28 rtl:!font-semibold">
                            {{ $t('validation.attributes.phone_number') }}
                        </div>
                        {{ benefactor.phone }}
                    </div>

                    <div class="mt-2 flex">
                        <div class="w-28 rtl:!font-semibold">
                            {{ $t('validation.attributes.address') }}
                        </div>
                        {{ benefactor.address }}
                    </div>

                    <div class="mt-2 flex">
                        <base-tippy
                            :content="$t('added_at')"
                            class="flex w-fit items-center truncate rounded-full bg-slate-100 px-2 py-1 text-xs font-semibold text-slate-400/80 dark:bg-darkmode-400"
                        >
                            {{ benefactor.created_at }}
                        </base-tippy>

                        <div class="ms-auto flex items-center">
                            <a
                                v-if="hasPermission('view_benefactors')"
                                class="me-2 flex items-center"
                                href="javascript:void(0)"
                                @click="emit('showDetailsModal', benefactor.id)"
                            >
                                {{ $t('show') }}
                            </a>

                            <a
                                v-if="hasPermission('update_benefactors')"
                                class="me-2 font-semibold text-slate-500 dark:text-slate-400"
                                href="javascript:void(0)"
                                @click="emit('showEditModal', benefactor.id)"
                                >{{ $t('edit') }}
                            </a>

                            <a
                                v-if="hasPermission('delete_benefactors')"
                                class="font-semibold text-danger"
                                href="javascript:void(0)"
                                @click="emit('showDeleteModal', benefactor.id)"
                            >
                                {{ $t('delete') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
