<script lang="ts" setup>
import { defineAsyncComponent } from 'vue'

import { $t } from '@/utils/i18n'

const BaseTable = defineAsyncComponent(() => import('@/Components/Base/table/BaseTable.vue'))

const BaseTbodyTable = defineAsyncComponent(() => import('@/Components/Base/table/BaseTbodyTable.vue'))

const BaseTdTable = defineAsyncComponent(() => import('@/Components/Base/table/BaseTdTable.vue'))

const BaseThTable = defineAsyncComponent(() => import('@/Components/Base/table/BaseThTable.vue'))

const BaseTheadTable = defineAsyncComponent(() => import('@/Components/Base/table/BaseTheadTable.vue'))

const BaseTrTable = defineAsyncComponent(() => import('@/Components/Base/table/BaseTrTable.vue'))

defineProps<{
    lessons: {
        id: string
        academicLevel: string
        subject: string
        quota: number
    }[]
}>()
</script>

<template>
    <!-- Begin: Lessons-->
    <div class="col-span-12">
        <h2 class="text-base rtl:font-semibold">{{ $t('the_lessons') }}</h2>

        <div v-if="lessons.length" class="mt-1 overflow-x-auto">
            <base-table sm striped>
                <base-thead-table>
                    <base-tr-table>
                        <base-th-table class="whitespace-nowrap">#</base-th-table>

                        <base-th-table class="whitespace-nowrap">
                            {{ $t('academic_level') }}
                        </base-th-table>

                        <base-th-table class="whitespace-nowrap">
                            {{ $t('the_subject') }}
                        </base-th-table>

                        <base-th-table class="whitespace-nowrap">
                            {{ $t('validation.attributes.quota') }}
                        </base-th-table>
                    </base-tr-table>
                </base-thead-table>

                <base-tbody-table>
                    <base-tr-table v-for="(lesson, index) in lessons" :key="lesson.id" class="text-center">
                        <base-td-table> {{ index + 1 }}</base-td-table>

                        <base-td-table>
                            {{ lesson.academicLevel }}
                        </base-td-table>

                        <base-td-table>
                            {{ lesson.subject }}
                        </base-td-table>

                        <base-td-table>
                            {{ lesson.quota }}
                        </base-td-table>
                    </base-tr-table>
                </base-tbody-table>
            </base-table>
        </div>

        <p v-else class="mt-1 text-center text-base rtl:font-semibold">
            {{ $t('no_sponsorships') }}
        </p>
    </div>
    <!-- End: Lessons-->
</template>
