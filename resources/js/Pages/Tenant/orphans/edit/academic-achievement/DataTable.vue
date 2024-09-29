<script lang="ts" setup>
import type { OrphanUpdateFormType } from '@/types/orphans'

import BaseTable from '@/Components/Base/table/BaseTable.vue'
import BaseTbodyTable from '@/Components/Base/table/BaseTbodyTable.vue'
import BaseTdTable from '@/Components/Base/table/BaseTdTable.vue'
import BaseThTable from '@/Components/Base/table/BaseThTable.vue'
import BaseTheadTable from '@/Components/Base/table/BaseTheadTable.vue'
import BaseTrTable from '@/Components/Base/table/BaseTrTable.vue'
import BaseTippy from '@/Components/Base/tippy/BaseTippy.vue'
import SvgLoader from '@/Components/SvgLoader.vue'

defineProps<{
    orphan: OrphanUpdateFormType
}>()

const emit = defineEmits(['showDeleteModal', 'showEditModal'])
</script>

<template>
    <div v-if="orphan.academic_achievements.length" class="mt-3 w-full flex-1 overflow-x-auto pb-2">
        <base-table class="border">
            <base-thead-table>
                <base-tr-table>
                    <base-th-table class="whitespace-nowrap bg-slate-50 text-slate-500 dark:bg-darkmode-800">
                        #
                    </base-th-table>
                    <base-th-table class="whitespace-nowrap bg-slate-50 text-slate-500 dark:bg-darkmode-800">
                        {{ $t('academic_level') }}
                    </base-th-table>
                    <base-th-table class="whitespace-nowrap bg-slate-50 text-slate-500 dark:bg-darkmode-800">
                        <div class="flex items-center">
                            {{ $t('validation.attributes.first_trimester') }}
                        </div>
                    </base-th-table>
                    <base-th-table class="whitespace-nowrap bg-slate-50 !px-2 text-slate-500 dark:bg-darkmode-800">
                        {{ $t('validation.attributes.second_trimester') }}
                    </base-th-table>

                    <base-th-table class="whitespace-nowrap bg-slate-50 !ps-2 text-slate-500 dark:bg-darkmode-800">
                        {{ $t('validation.attributes.third_trimester') }}
                    </base-th-table>

                    <base-th-table class="whitespace-nowrap bg-slate-50 !ps-2 text-slate-500 dark:bg-darkmode-800">
                        {{ $t('general_average') }}
                    </base-th-table>

                    <base-th-table class="whitespace-nowrap bg-slate-50 !ps-2 text-slate-500 dark:bg-darkmode-800">
                        {{ $t('validation.attributes.note') }}
                    </base-th-table>

                    <base-th-table class="whitespace-nowrap bg-slate-50 !ps-2 text-slate-500 dark:bg-darkmode-800">
                        {{ $t('actions') }}
                    </base-th-table>
                </base-tr-table>
            </base-thead-table>

            <base-tbody-table>
                <base-tr-table
                    v-for="(academic_achievement, index) in orphan.academic_achievements"
                    :key="academic_achievement.id"
                >
                    <base-td-table>
                        {{ index + 1 }}
                    </base-td-table>

                    <base-td-table class="text-center">
                        {{ academic_achievement.academic_level }}
                    </base-td-table>

                    <base-td-table>
                        {{ academic_achievement.first_trimester }}
                    </base-td-table>

                    <base-td-table>
                        {{ academic_achievement.second_trimester }}
                    </base-td-table>

                    <base-td-table>
                        {{ academic_achievement.third_trimester }}
                    </base-td-table>

                    <base-td-table>
                        {{ academic_achievement.average }}
                    </base-td-table>

                    <base-td-table class="text-center">
                        <base-tippy v-if="academic_achievement?.note" :content="academic_achievement?.note">
                            <svg-loader class="mx-auto block h-6 w-6" name="icon-note"></svg-loader>
                        </base-tippy>

                        <span v-else> - </span>
                    </base-td-table>

                    <base-td-table>
                        <div class="flex items-center justify-center">
                            <a
                                class="me-3 flex items-center"
                                href="javascript:void(0)"
                                @click.prevent="emit('showEditModal', academic_achievement.id)"
                            >
                                <svg-loader class="me-1 h-4 w-4 fill-current" name="icon-pen" />
                            </a>
                            <a
                                class="flex items-center text-danger"
                                href="javascript:void(0)"
                                @click.prevent="emit('showDeleteModal', academic_achievement.id)"
                            >
                                <svg-loader class="me-1 h-4 w-4 fill-current" name="icon-trash-can" />
                            </a>
                        </div>
                    </base-td-table>
                </base-tr-table>
            </base-tbody-table>
        </base-table>
    </div>
</template>
