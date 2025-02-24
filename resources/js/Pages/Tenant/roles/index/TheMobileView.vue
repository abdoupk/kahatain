<script lang="ts" setup>
import type { IndexParams, PaginationData, RolesIndexResource } from '@/types/types'

import BaseTippy from '@/Components/Base/tippy/BaseTippy.vue'

import { formatDate, hasPermission } from '@/utils/helper'

defineProps<{
    roles: PaginationData<RolesIndexResource>
    params: IndexParams
}>()

// eslint-disable-next-line
const emit = defineEmits(['sort', 'showDeleteModal', 'showEditModal'])
</script>

<template>
    <div class="col-span-12 my-8 grid grid-cols-12 gap-4 @3xl:hidden">
        <div v-for="role in roles.data" :key="role.uuid" class="intro-y !z-10 col-span-12 @xl:col-span-6">
            <div class="box p-5">
                <div class="flex">
                    <div class="me-3 truncate text-lg font-medium">
                        {{ role.name }}
                    </div>

                    <base-tippy
                        :content="$t('added_at')"
                        class="ms-auto flex cursor-pointer items-center truncate rounded-full bg-slate-100 px-2 py-1 text-xs text-slate-500 dark:bg-darkmode-400"
                    >
                        {{ formatDate(role.created_at, 'full') }}
                    </base-tippy>
                </div>

                <div class="mt-6 flex">
                    <div class="flex w-3/4 flex-col gap-4">
                        <div class="flex">
                            <div class="w-28 rtl:!font-semibold">
                                {{ $t('users_count') }}
                            </div>
                            {{ role.users_count }}
                        </div>

                        <div class="flex">
                            <div class="w-28 rtl:!font-semibold">
                                {{ $t('permissions_count') }}
                            </div>

                            {{ role.permissions_count }}
                        </div>
                    </div>

                    <div class="flex w-1/4 items-center justify-end">
                        <a
                            v-if="hasPermission('update_roles')"
                            class="me-2 font-semibold text-slate-500 dark:text-slate-400"
                            href="#"
                            @click="emit('showEditModal', role.uuid)"
                            >{{ $t('edit') }}
                        </a>

                        <a
                            v-if="hasPermission('delete_roles')"
                            class="font-semibold text-danger"
                            href="javascript:void(0)"
                            @click="emit('showDeleteModal', role.uuid)"
                        >
                            {{ $t('delete') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
