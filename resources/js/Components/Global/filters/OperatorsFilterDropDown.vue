<script lang="ts" setup>
import type { ListBoxOperator } from '@/types/types'

import { Listbox, ListboxButton, ListboxOption, ListboxOptions } from '@headlessui/vue'

import SvgLoader from '@/Components/Global/SvgLoader.vue'

defineProps<{ operators: ListBoxOperator[] }>()

const selected = defineModel<ListBoxOperator>('selected')
</script>

<template>
    <listbox v-model="selected" as="div">
        <div class="relative mt-2">
            <listbox-button
                class="relative w-full cursor-default rounded-md border bg-white py-1.5 pe-10 ps-3 text-start text-gray-900 shadow-sm focus:ring-4 focus:ring-primary focus:ring-opacity-20 dark:bg-darkmode-800 dark:text-slate-300 dark:focus:ring-slate-700 dark:focus:ring-opacity-50 sm:text-sm sm:leading-6"
            >
                <span class="ms-3 block truncate">{{ $t(selected?.label ?? '') }}</span>

                <span class="pointer-events-none absolute inset-y-0 end-0 ms-3 flex items-center pe-2">
                    <svg-loader aria-hidden="true" class="h-5 w-5 text-gray-400" name="icon-angles-up-down" />
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
                        v-for="operator in operators"
                        :key="operator.value"
                        v-slot="{ active, selected }"
                        :value="operator"
                        as="template"
                    >
                        <li
                            :class="[
                                active ? 'bg-primary text-white' : 'text-gray-900 dark:text-slate-300',
                                'relative cursor-default select-none py-2 pe-9 ps-3'
                            ]"
                        >
                            <div class="flex items-center">
                                <span :class="[selected ? 'font-semibold' : 'font-normal', 'ms-3 block truncate']">{{
                                    $t(operator.label)
                                }}</span>
                            </div>

                            <span
                                v-if="selected"
                                :class="[
                                    active ? 'text-white' : 'text-primary',
                                    'absolute inset-y-0 end-0 flex items-center pe-4'
                                ]"
                            >
                            </span>
                        </li>
                    </listbox-option>
                </listbox-options>
            </transition>
        </div>
    </listbox>
</template>
