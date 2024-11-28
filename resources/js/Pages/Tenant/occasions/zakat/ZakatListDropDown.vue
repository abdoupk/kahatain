<script lang="ts" setup>
import { Listbox, ListboxButton, ListboxOption, ListboxOptions } from '@headlessui/vue'
import { watch } from 'vue'

import SvgLoader from '@/Components/Global/SvgLoader.vue'
import FilterValueDropDownListOption from '@/Components/Global/filters/FilterValueDropDownListOption.vue'

import { $t } from '@/utils/i18n'

defineProps<{ data: { id: string; name: string }[] }>()

const value = defineModel<
    | {
          id: string
          name: string
      }
    | string
>('value', '')

watch(
    () => value.value,
    (newValue) => {
        if (newValue === '')
            value.value = {
                id: '',
                name: 'filters.select_an_option'
            }
    },
    { immediate: true }
)
</script>

<template>
    <listbox v-model="value" as="div">
        <div class="relative mt-2">
            <listbox-button
                class="relative w-full cursor-default rounded-md border bg-white py-1.5 pe-10 ps-3 text-start text-gray-900 shadow-sm focus:ring-4 focus:ring-primary focus:ring-opacity-20 dark:bg-darkmode-800 dark:text-slate-300 dark:focus:ring-slate-700 dark:focus:ring-opacity-50 sm:text-sm sm:leading-6"
            >
                <span class="ms-3 block truncate">
                    {{ value?.name !== 'filters.select_an_option' ? value?.name : $t('filters.select_an_option') }}
                </span>

                <span class="pointer-events-none absolute inset-y-0 end-0 ms-3 flex items-center pe-2">
                    <svg-loader
                        aria-hidden="true"
                        class="h-5 w-5 text-gray-400"
                        name="icon-angles-up-down"
                    ></svg-loader>
                </span>
            </listbox-button>

            <transition
                leave-active-class="transition ease-in duration-100"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <listbox-options
                    class="absolute z-10 mt-1 max-h-56 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none dark:bg-darkmode-800 sm:text-sm"
                >
                    <listbox-option
                        v-for="datum in data"
                        :key="datum.id"
                        v-slot="{ active, selected }"
                        :value="datum"
                        as="template"
                    >
                        <filter-value-drop-down-list-option
                            :active
                            :label="datum.name"
                            :selected
                        ></filter-value-drop-down-list-option>
                    </listbox-option>
                </listbox-options>
            </transition>
        </div>
    </listbox>
</template>
