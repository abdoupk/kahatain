<script lang="ts" setup>
import BaseTable from '@/Components/Base/table/BaseTable.vue'
import BaseTbodyTable from '@/Components/Base/table/BaseTbodyTable.vue'
import BaseTheadTable from '@/Components/Base/table/BaseTheadTable.vue'
import BaseTrTable from '@/Components/Base/table/BaseTrTable.vue'
import TheTableTd from '@/Components/Global/DataTable/TheTableTd.vue'
import TheTableTh from '@/Components/Global/DataTable/TheTableTh.vue'

defineProps<{
    students: any
    params: any
}>()

const emit = defineEmits(['sort'])
</script>

<template>
    <div class="@container">
        <div class="intro-y !z-30 col-span-12 hidden overflow-x-auto @3xl:block">
            <base-table class="mt-2 border-separate border-spacing-y-[10px]">
                <base-thead-table>
                    <base-tr-table>
                        <the-table-th class="text-start"> #</the-table-th>

                        <the-table-th class="text-start">
                            {{ $t('the_orphan') }}
                        </the-table-th>

                        <the-table-th
                            v-for="(subject, index) in students.data[0].subjects"
                            :key="subject.id"
                            :direction="
                                params.directions && params.directions[`first_trimester.grade_${String(index)}`]
                            "
                            class="text-start"
                            sortable
                            @click="emit('sort', `first_trimester.grade_${String(index)}`)"
                        >
                            {{ subject.name }}
                        </the-table-th>
                    </base-tr-table>
                </base-thead-table>

                <base-tbody-table>
                    <base-tr-table v-for="(orphan, index) in students.data" :key="orphan.id" class="intro-x">
                        <the-table-td class="w-16">
                            {{ (students.meta.from ?? 0) + index }}
                        </the-table-td>

                        <the-table-td class="!min-w-40 !max-w-40 truncate">
                            {{ orphan.orphan.name }}
                        </the-table-td>

                        <the-table-td v-for="subject in orphan.subjects" :key="subject.id" class=""
                            >{{ subject.grade }}
                        </the-table-td>
                    </base-tr-table>
                </base-tbody-table>
            </base-table>
        </div>
    </div>
</template>
