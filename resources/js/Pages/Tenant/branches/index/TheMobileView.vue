<script lang="ts" setup>
import type { BranchesIndexResource, IndexParams, PaginationData } from '@/types/types'

import BaseTippy from '@/Components/Base/tippy/BaseTippy.vue'

import { hasPermission } from '@/utils/helper'
import { $t } from '@/utils/i18n'

defineProps<{
    branches: PaginationData<BranchesIndexResource>
    params: IndexParams
}>()

// eslint-disable-next-line array-element-newline
const emit = defineEmits(['sort', 'showDeleteModal', 'showEditModal', 'showDetailsModal'])
</script>

<template>
    <div class="col-span-12 my-8 grid grid-cols-12 gap-4 @4xl:hidden">
        <div v-for="branch in branches.data" :key="branch.id" class="intro-y !z-10 col-span-12 @xl:col-span-6">
            <div class="box p-5">
                <div class="flex">
                    <div class="me-4 truncate ltr:font-medium rtl:text-lg rtl:font-semibold">
                        {{ branch.name }}
                    </div>

                    <base-tippy
                        :content="`${$t('branch_president')}: ${branch.president?.name}`"
                        class="ms-auto flex w-fit cursor-pointer items-center truncate whitespace-nowrap rounded-full bg-slate-100 px-2 py-1 text-xs text-slate-500 dark:bg-darkmode-400"
                    >
                        {{ branch.president?.name }}
                    </base-tippy>
                </div>

                <div class="mt-4">
                    <div class="flex">
                        <div class="w-28 rtl:!font-semibold">
                            {{ $t('location') }}
                        </div>
                        {{ branch.city }}
                    </div>

                    <div class="mt-2 flex">
                        <div class="w-28 rtl:!font-semibold">
                            {{ $t('families_count') }}
                        </div>
                        {{ branch.families_count }}
                    </div>

                    <div class="mt-2 flex">
                        <div class="w-28 rtl:!font-semibold">
                            {{ $t('users_count') }}
                        </div>
                        {{ branch.members_count }}
                    </div>

                    <div class="mt-2 flex">
                        <base-tippy
                            :content="$t('added_at')"
                            class="flex w-fit items-center truncate rounded-full bg-slate-100 px-2 py-1 text-xs font-semibold text-slate-400/80 dark:bg-darkmode-400"
                        >
                            {{ branch.created_at }}
                        </base-tippy>

                        <div class="ms-auto flex items-center">
                            <a
                                v-if="hasPermission('view_branches')"
                                class="me-2 font-semibold text-slate-500 dark:text-slate-400"
                                href="javascript:void(0)"
                                @click.prevent="emit('showDetailsModal', branch.id)"
                                >{{ $t('show') }}
                            </a>

                            <a
                                v-if="hasPermission('update_branches')"
                                class="me-2 font-semibold text-slate-500 dark:text-slate-400"
                                href="javascript:void(0)"
                                @click.prevent="emit('showEditModal', branch.id)"
                                >{{ $t('edit') }}
                            </a>

                            <a
                                v-if="hasPermission('delete_branches')"
                                class="font-semibold text-danger"
                                href="javascript:void(0)"
                                @click="emit('showDeleteModal', branch.id)"
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
