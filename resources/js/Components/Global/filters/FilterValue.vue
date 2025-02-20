<script lang="ts" setup>
import type { FilterValueType, ListBoxFilter } from '@/types/types'

import { defineAsyncComponent } from 'vue'

import SpinnerLoader from '@/Components/Global/SpinnerLoader.vue'

const ObjectFilters = defineAsyncComponent(() => import('@/Components/Global/filters/ObjectFilters.vue'))

const BaseVCalendar = defineAsyncComponent(() => import('@/Components/Base/VCalendar/BaseVCalendar.vue'))

const BaseFormInput = defineAsyncComponent(() => import('@/Components/Base/form/BaseFormInput.vue'))

const BaseFormSelect = defineAsyncComponent(() => import('@/Components/Base/form/BaseFormSelect.vue'))

defineProps<{ field?: ListBoxFilter }>()

const value = defineModel<FilterValueType>('value')
</script>

<template>
    <div class="col-span-6 md:col-span-4">
        <suspense v-if="field?.type === 'object'">
            <object-filters v-model:value="value" :field></object-filters>

            <template #fallback>
                <div class="flex h-full items-center justify-center">
                    <spinner-loader class="h-5 w-5"></spinner-loader>
                </div>
            </template>
        </suspense>

        <suspense v-else-if="field?.type === 'date'" suspensible>
            <div class="mt-2">
                <base-v-calendar v-model="value"></base-v-calendar>
            </div>

            <template #fallback>
                <div class="flex h-full items-center justify-center">
                    <spinner-loader class="h-5 w-5"></spinner-loader>
                </div>
            </template>
        </suspense>

        <suspense v-else-if="field?.type === 'string'" suspensible>
            <base-form-input
                v-model="value"
                :placeholder="
                    $t('auth.placeholders.fill', {
                        attribute: $t('the_value')
                    })
                "
                class="mt-2 text-sm"
                type="text"
            ></base-form-input>
        </suspense>

        <suspense v-else-if="field?.type === 'number'" suspensible>
            <base-form-input
                v-model="value"
                :placeholder="
                    $t('auth.placeholders.fill', {
                        attribute: $t('the_value')
                    })
                "
                class="mt-2 text-sm"
                type="number"
            ></base-form-input>
        </suspense>

        <suspense v-else-if="field?.type === 'boolean'" suspensible>
            <base-form-select v-model="value" class="mt-2 text-sm">
                <option :value="true" selected>{{ $t('yes') }}</option>
                <option :value="false">{{ $t('no') }}</option>
            </base-form-select>
        </suspense>
    </div>
</template>
