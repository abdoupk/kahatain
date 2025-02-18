<script lang="ts" setup>
import type { FilterValueType, ListBoxFilter, ListBoxOperator, PopOverPlacementType } from '@/types/types'

import { defineAsyncComponent, ref } from 'vue'

import BaseButton from '@/Components/Base/button/BaseButton.vue'
import BasePopover from '@/Components/Base/headless/Popover/BasePopover.vue'
import BasePopoverButton from '@/Components/Base/headless/Popover/BasePopoverButton.vue'
import BasePopoverPanel from '@/Components/Base/headless/Popover/BasePopoverPanel.vue'
import SpinnerLoader from '@/Components/Global/SpinnerLoader.vue'

import { $t } from '@/utils/i18n'

const FilterRule = defineAsyncComponent(() => import('@/Components/Global/filters/FilterRule.vue'))

const FilterValue = defineAsyncComponent(() => import('@/Components/Global/filters/FilterValue.vue'))

const SvgLoader = defineAsyncComponent(() => import('@/Components/SvgLoader.vue'))

const { placement = 'bottom-start' } = defineProps<{
    filters: ListBoxFilter[]
    placement?: PopOverPlacementType
}>()

const emit = defineEmits(['update:value', 'reset-filter'])

const field = ref<ListBoxFilter>()

const operator = ref<ListBoxOperator>()

const value = ref<FilterValueType>('')

const filterRules = ref([
    {
        field: field.value,
        operator: operator.value,
        value: value.value
    }
])

// eslint-disable-next-line @typescript-eslint/ban-types
const removeFilterRule = (close: Function) => {
    if (filterRules.value.length > 1) {
        filterRules.value.pop()
    } else {
        close()

        setTimeout(() => {
            filterRules.value = []

            emit('reset-filter')
        }, 200)
    }

    emit('update:value', filterRules.value)
}

const addFilterRule = () => {
    filterRules.value.push({
        field: field.value,
        operator: operator.value,
        value: ''
    })
}

const handleChange = (value: string, index: number) => {
    filterRules.value[index].value = value

    emit('update:value', filterRules.value)
}

const handleOperatorChange = (index: number) => {
    filterRules.value[index].value = ''
}

const handleFieldChange = (index: number) => {
    if (filterRules.value[index].field?.operators[0])
        filterRules.value[index].operator = filterRules.value[index]?.field?.operators[0]

    if (filterRules.value[index].field?.type === 'string') {
        filterRules.value[index].value = ''
    }

    if (filterRules.value[index].field?.type === 'object') {
        if (
            filterRules.value[index].field?.label === 'family_sponsorships' ||
            filterRules.value[index].field?.label === 'sponsor_sponsorships' ||
            filterRules.value[index].field?.label === 'orphan_sponsorships' ||
            filterRules.value[index].field?.label === 'gender' ||
            filterRules.value[index].field?.label === 'sponsor_type'
        ) {
            filterRules.value[index].value = {
                value: '',
                label: $t('filters.select_an_option')
            }
        } else
            filterRules.value[index].value = {
                id: '',
                name: $t('filters.select_an_option')
            }
    }

    emit('update:value', filterRules.value)
}
</script>

<template>
    <div>
        <base-popover v-slot="{ close }" class="inline-block">
            <base-popover-button :as="BaseButton" variant="outline-secondary">
                <svg-loader class="fill-primary dark:fill-slate-400" name="icon-filters"></svg-loader>
            </base-popover-button>

            <base-popover-panel :placement>
                <suspense suspensible>
                    <div class="w-[280px] px-2 pt-2 sm:w-[350-px] md:w-[505px] lg:w-[580px]">
                        <div class="grid grid-cols-12 gap-4">
                            <filter-rule
                                v-for="(rule, index) in filterRules"
                                :key="index"
                                v-model:field="filterRules[index].field"
                                v-model:operator="filterRules[index].operator"
                                :filters
                                @update:field-value="handleFieldChange(index)"
                                @update:operator-value="handleOperatorChange(index)"
                            >
                                <template #default>
                                    <filter-value
                                        v-model:value="rule.value"
                                        :field="rule.field"
                                        @update:value="handleChange($event, index)"
                                    ></filter-value>
                                </template>
                            </filter-rule>
                        </div>

                        <a
                            class="-ms-1 mt-2 flex rounded-md p-1 hover:bg-slate-200/60 dark:hover:bg-darkmode-400"
                            href="#"
                            @click.prevent="addFilterRule"
                        >
                            <svg-loader
                                class="h-4 w-4 fill-slate-500 dark:fill-slate-400"
                                name="icon-plus"
                            ></svg-loader>

                            <span class="ms-0.5 font-medium text-slate-500 dark:text-slate-400">
                                {{ $t('add_filter') }}
                            </span>
                        </a>
                    </div>

                    <template #fallback>
                        <div
                            class="flex w-[280px] items-center justify-center px-2 pt-2 sm:w-[350-px] md:w-[505px] lg:w-[580px]"
                        >
                            <spinner-loader class="h-5 w-5"></spinner-loader>
                        </div>
                    </template>
                </suspense>

                <div class="-mx-2 mt-2 border-t border-slate-200">
                    <a
                        class="group mx-2 mt-2 flex rounded-md p-1 hover:bg-slate-200/60 dark:hover:bg-darkmode-400"
                        href="#"
                        @click.prevent="removeFilterRule(close)"
                    >
                        <svg-loader
                            class="ms-1 h-4 w-4 fill-slate-500 group-hover:fill-red-500 dark:fill-slate-300"
                            name="icon-trash-can"
                        ></svg-loader>

                        <span class="ms-1 font-medium text-slate-500 group-hover:text-red-500 dark:text-slate-300">{{
                                $t('delete_filter')
                            }}</span>
                    </a>
                </div>
            </base-popover-panel>
        </base-popover>
    </div>
</template>
