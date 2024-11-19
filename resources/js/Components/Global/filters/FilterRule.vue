<script lang="ts" setup>
import type { ListBoxFilter, ListBoxOperator } from '@/types/types'

import { onMounted, ref, watch } from 'vue'

import FieldsFilterDropDown from '@/Components/Global/filters/FieldsFilterDropDown.vue'
import OperatorsFilterDropDown from '@/Components/Global/filters/OperatorsFilterDropDown.vue'

defineProps<{ filters: ListBoxFilter[] }>()

const emit = defineEmits(['update:fieldValue', 'update:operatorValue'])

const operators = ref<ListBoxOperator[]>([])

const field = defineModel<ListBoxFilter>('field')

const operator = defineModel<ListBoxOperator>('operator')

watch(
    () => field.value,
    (newField) => {
        newField?.operators && (operators.value = newField.operators)

        operator.value = operators.value[0]

        emit('update:fieldValue')
    }
)

watch(
    () => operator.value,
    () => emit('update:operatorValue')
)

onMounted(() => {
    if (field.value?.operators) operators.value = field.value.operators
})
</script>

<template>
    <div class="col-span-12 grid grid-cols-12 gap-4">
        <fields-filter-drop-down
            v-model:selected="field"
            :filters
            class="col-span-12 md:col-span-4"
        ></fields-filter-drop-down>

        <operators-filter-drop-down
            v-if="field?.type !== 'boolean'"
            v-model:selected="operator"
            :operators
            class="col-span-6 md:col-span-4"
        ></operators-filter-drop-down>

        <slot></slot>
    </div>
</template>
