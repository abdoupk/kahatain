<script lang="ts" setup>
import BaseTable from '@/Components/Base/table/BaseTable.vue'
import BaseTbodyTable from '@/Components/Base/table/BaseTbodyTable.vue'
import BaseTheadTable from '@/Components/Base/table/BaseTheadTable.vue'
import BaseTrTable from '@/Components/Base/table/BaseTrTable.vue'
import TheTableTd from '@/Components/Global/DataTable/TheTableTd.vue'
import TheTableTh from '@/Components/Global/DataTable/TheTableTh.vue'

defineProps<{
    grades: unknown
    averages: unknown
}>()
</script>

<template>
    <div class="@container">
        <div class="intro-y !z-30 col-span-12 overflow-x-auto">
            <base-table class="mt-2 border-separate border-spacing-y-[10px]">
                <base-thead-table>
                    <base-tr-table>
                        <the-table-th class="text-start"> #</the-table-th>

                        <the-table-th class="text-center">
                            {{ $t('the_subject') }}
                        </the-table-th>

                        <the-table-th class="text-center">
                            {{ $t('average_first_trimester') }}
                        </the-table-th>

                        <the-table-th class="text-center">
                            {{ $t('average_second_trimester') }}
                        </the-table-th>

                        <the-table-th class="text-center">
                            {{ $t('average_third_trimester') }}
                        </the-table-th>

                        <the-table-th class="text-center">
                            {{ $t('general_average') }}
                        </the-table-th>
                    </base-tr-table>
                </base-thead-table>

                <base-tbody-table>
                    <base-tr-table v-for="(subject, index) in grades[0]" :key="index" class="intro-x">
                        <the-table-td class="w-16">
                            {{ index + 1 }}
                        </the-table-td>

                        <the-table-td class="text-nowrap text-center">
                            {{ subject.name }}
                        </the-table-td>

                        <the-table-td class="text-center">
                            {{ grades[0][index].grade }}
                        </the-table-td>

                        <the-table-td class="text-center">
                            {{ grades[1][index].grade }}
                        </the-table-td>

                        <the-table-td class="text-center">
                            {{ grades[2][index].grade }}
                        </the-table-td>

                        <the-table-td class="text-center">
                            {{
                                (
                                    (Number(grades[0][index].grade) +
                                        Number(grades[1][index].grade) +
                                        Number(grades[2][index].grade)) /
                                    3
                                ).toFixed(2)
                            }}
                        </the-table-td>
                    </base-tr-table>

                    <base-tr-table class="intro-x">
                        <the-table-td></the-table-td>

                        <the-table-td class="text-center font-medium rtl:!font-semibold">
                            {{ $t('the_average') }}
                        </the-table-td>

                        <the-table-td class="text-center font-medium rtl:!font-semibold">
                            {{ averages[0] }}
                        </the-table-td>

                        <the-table-td class="text-center font-medium rtl:!font-semibold">
                            {{ averages[1] }}
                        </the-table-td>

                        <the-table-td class="text-center font-medium rtl:!font-semibold">
                            {{ averages[2] }}
                        </the-table-td>

                        <the-table-td class="text-center font-medium rtl:!font-semibold">
                            {{ ((Number(averages[0]) + Number(averages[1]) + Number(averages[2])) / 3).toFixed(2) }}
                        </the-table-td>
                    </base-tr-table>
                </base-tbody-table>
            </base-table>
        </div>
    </div>
</template>
