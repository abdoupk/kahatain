<script lang="ts" setup>
import type { OrphanShowType } from '@/types/orphans'

import BaseTable from '@/Components/Base/table/BaseTable.vue'
import BaseTbodyTable from '@/Components/Base/table/BaseTbodyTable.vue'
import BaseTdTable from '@/Components/Base/table/BaseTdTable.vue'
import BaseThTable from '@/Components/Base/table/BaseThTable.vue'
import BaseTheadTable from '@/Components/Base/table/BaseTheadTable.vue'
import BaseTrTable from '@/Components/Base/table/BaseTrTable.vue'
import BaseTippy from '@/Components/Base/tippy/BaseTippy.vue'
import SvgLoader from '@/Components/SvgLoader.vue'

defineProps<{
    orphan: OrphanShowType
}>()
</script>

<template>
    <base-table class="mt-2 border-separate border-spacing-y-[10px] overflow-x-auto">
        <base-thead-table>
            <base-tr-table>
                <base-th-table class="whitespace-nowrap border-b-0 text-start font-semibold"> #</base-th-table>

                <base-th-table class="whitespace-nowrap border-b-0 text-start font-semibold">
                    {{ $t('academic_level') }}
                </base-th-table>

                <base-th-table class="whitespace-nowrap border-b-0 text-start font-semibold">
                    {{ $t('academic_year') }}
                </base-th-table>

                <base-th-table class="whitespace-nowrap border-b-0 text-start font-semibold">
                    {{ $t('validation.attributes.first_trimester') }}
                </base-th-table>

                <base-th-table class="whitespace-nowrap border-b-0 text-start font-semibold">
                    {{ $t('validation.attributes.second_trimester') }}
                </base-th-table>

                <base-th-table class="whitespace-nowrap border-b-0 text-start font-semibold">
                    {{ $t('validation.attributes.third_trimester') }}
                </base-th-table>

                <base-th-table class="whitespace-nowrap border-b-0 text-start font-semibold">
                    {{ $t('general_average') }}
                </base-th-table>

                <base-th-table class="whitespace-nowrap border-b-0 text-start font-semibold">
                    {{ $t('validation.attributes.note') }}
                </base-th-table>
            </base-tr-table>
        </base-thead-table>

        <base-tbody-table>
            <base-tr-table
                v-for="(academic_achievement, index) in orphan.academic_achievements"
                :key="academic_achievement.id"
                class="intro-x"
            >
                <base-td-table
                    class="w-16 border-b-0 bg-white first:rounded-s-md last:rounded-e-md dark:bg-darkmode-600 ltr:shadow-[20px_3px_20px_#0000000b] rtl:shadow-[-20px_3px_20px_#0000000b]"
                >
                    {{ index + 1 }}
                </base-td-table>

                <base-td-table
                    class="!min-w-40 !max-w-40 truncate border-b-0 bg-white first:rounded-s-md last:rounded-e-md dark:bg-darkmode-600 ltr:shadow-[20px_3px_20px_#0000000b] rtl:shadow-[-20px_3px_20px_#0000000b]"
                >
                    {{ academic_achievement.academic_level }}
                </base-td-table>

                <base-td-table
                    class="border-b-0 bg-white text-center first:rounded-s-md last:rounded-e-md dark:bg-darkmode-600 ltr:shadow-[20px_3px_20px_#0000000b] rtl:shadow-[-20px_3px_20px_#0000000b]"
                >
                    {{ academic_achievement.academic_year }}
                </base-td-table>

                <base-td-table
                    class="max-w-40 truncate border-b-0 bg-white text-center first:rounded-s-md last:rounded-e-md dark:bg-darkmode-600 ltr:shadow-[20px_3px_20px_#0000000b] rtl:shadow-[-20px_3px_20px_#0000000b]"
                >
                    {{ academic_achievement.first_trimester }}
                </base-td-table>

                <base-td-table
                    class="border-b-0 bg-white text-center first:rounded-s-md last:rounded-e-md dark:bg-darkmode-600 ltr:shadow-[20px_3px_20px_#0000000b] rtl:shadow-[-20px_3px_20px_#0000000b]"
                >
                    {{ academic_achievement.second_trimester }}
                </base-td-table>

                <base-td-table
                    class="border-b-0 bg-white text-center first:rounded-s-md last:rounded-e-md dark:bg-darkmode-600 ltr:shadow-[20px_3px_20px_#0000000b] rtl:shadow-[-20px_3px_20px_#0000000b]"
                >
                    {{ academic_achievement.third_trimester }}
                </base-td-table>

                <base-td-table
                    class="border-b-0 bg-white text-center first:rounded-s-md last:rounded-e-md dark:bg-darkmode-600 ltr:shadow-[20px_3px_20px_#0000000b] rtl:shadow-[-20px_3px_20px_#0000000b]"
                >
                    {{ academic_achievement.average }}
                </base-td-table>

                <base-td-table
                    class="border-b-0 bg-white text-center first:rounded-s-md last:rounded-e-md dark:bg-darkmode-600 ltr:shadow-[20px_3px_20px_#0000000b] rtl:shadow-[-20px_3px_20px_#0000000b]"
                >
                    <base-tippy v-if="academic_achievement?.note" :content="academic_achievement?.note">
                        <svg-loader class="mx-auto block h-6 w-6" name="icon-note"></svg-loader>
                    </base-tippy>

                    <span v-else> - </span>
                </base-td-table>
            </base-tr-table>
        </base-tbody-table>
    </base-table>
</template>
