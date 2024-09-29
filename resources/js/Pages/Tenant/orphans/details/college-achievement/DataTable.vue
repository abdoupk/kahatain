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
                    {{ $t('university') }}
                </base-th-table>

                <base-th-table class="whitespace-nowrap border-b-0 text-start font-semibold">
                    {{ $t('validation.attributes.first_semester') }}
                </base-th-table>

                <base-th-table class="whitespace-nowrap border-b-0 text-start font-semibold">
                    {{ $t('validation.attributes.second_semester') }}
                </base-th-table>

                <base-th-table class="whitespace-nowrap border-b-0 text-center font-semibold">
                    {{ $t('general_average') }}
                </base-th-table>

                <base-th-table class="whitespace-nowrap border-b-0 text-start font-semibold">
                    {{ $t('validation.attributes.note') }}
                </base-th-table>
            </base-tr-table>
        </base-thead-table>

        <base-tbody-table>
            <base-tr-table
                v-for="(college_achievement, index) in orphan.college_achievements"
                :key="college_achievement.id"
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
                    {{ college_achievement.academic_level }}

                    <p class="mt-0.5 block whitespace-nowrap text-xs text-slate-500">
                        {{ college_achievement.speciality }}
                    </p>
                </base-td-table>

                <base-td-table
                    class="border-b-0 bg-white text-center first:rounded-s-md last:rounded-e-md dark:bg-darkmode-600 ltr:shadow-[20px_3px_20px_#0000000b] rtl:shadow-[-20px_3px_20px_#0000000b]"
                >
                    {{ college_achievement.year }}
                </base-td-table>

                <base-td-table
                    class="border-b-0 bg-white text-center first:rounded-s-md last:rounded-e-md dark:bg-darkmode-600 ltr:shadow-[20px_3px_20px_#0000000b] rtl:shadow-[-20px_3px_20px_#0000000b]"
                >
                    {{ college_achievement.university }}
                </base-td-table>

                <base-td-table
                    class="max-w-40 truncate border-b-0 bg-white text-center first:rounded-s-md last:rounded-e-md dark:bg-darkmode-600 ltr:shadow-[20px_3px_20px_#0000000b] rtl:shadow-[-20px_3px_20px_#0000000b]"
                >
                    {{ college_achievement.first_semester }}
                </base-td-table>

                <base-td-table
                    class="border-b-0 bg-white text-center first:rounded-s-md last:rounded-e-md dark:bg-darkmode-600 ltr:shadow-[20px_3px_20px_#0000000b] rtl:shadow-[-20px_3px_20px_#0000000b]"
                >
                    {{ college_achievement.second_semester }}
                </base-td-table>

                <base-td-table
                    class="border-b-0 bg-white text-center first:rounded-s-md last:rounded-e-md dark:bg-darkmode-600 ltr:shadow-[20px_3px_20px_#0000000b] rtl:shadow-[-20px_3px_20px_#0000000b]"
                >
                    {{ college_achievement.average }}
                </base-td-table>

                <base-td-table
                    class="border-b-0 bg-white text-center first:rounded-s-md last:rounded-e-md dark:bg-darkmode-600 ltr:shadow-[20px_3px_20px_#0000000b] rtl:shadow-[-20px_3px_20px_#0000000b]"
                >
                    <base-tippy v-if="college_achievement?.note" :content="college_achievement?.note">
                        <svg-loader class="mx-auto block h-6 w-6" name="icon-note"></svg-loader>
                    </base-tippy>

                    <span v-else> - </span>
                </base-td-table>
            </base-tr-table>
        </base-tbody-table>
    </base-table>
</template>
