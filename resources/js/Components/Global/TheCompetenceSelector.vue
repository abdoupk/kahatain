<script lang="ts" setup>
import { useCompetencesStore } from '@/stores/competences'
import { Combobox, ComboboxButton, ComboboxOption, ComboboxOptions } from '@headlessui/vue'
import { twMerge } from 'tailwind-merge'
import { computed, onMounted, ref } from 'vue'

import BaseComboboxInput from '@/Components/Base/headless/Combobox/BaseComboboxInput.vue'
import SvgLoader from '@/Components/SvgLoader.vue'

import { generateUUID } from '@/utils/helper'
import { $t } from '@/utils/i18n'

const competences = defineModel('competences')

const competencesStore = useCompetencesStore()

const options = ref([])

onMounted(async () => {
    await competencesStore.fetchCompetences()

    options.value = competencesStore.competences
})

const query = ref('')

const queryOption = computed(() => {
    return query.value === ''
        ? null
        : {
              id: generateUUID(),
              name: query.value
          }
})

const filteredCompetences = computed(() =>
    query.value === ''
        ? competencesStore.competences
        : competencesStore.competences.filter((competence) => {
              return competence.name.toLowerCase().includes(query.value.toLowerCase())
          })
)

const handleUpdate = (value) => {
    value.forEach((competence) => {
        if (!options.value.some((c) => c.id === competence.id)) {
            options.value.push(competence)
        }
    })
}
</script>
<template>
    <combobox v-model="competences" as="div" by="name" multiple @update:model-value="handleUpdate">
        <div :class="twMerge(['relative', $attrs.class])">
            <base-combobox-input
                :displayValue="(competence) => competence.name"
                :placeholder="$t('search_or_add_a_competence')"
                @change="query = $event.target.value"
            ></base-combobox-input>

            <combobox-button class="absolute inset-y-0 end-0 flex items-center pe-2">
                <svg-loader aria-hidden="true" class="h-5 w-5 text-gray-400" name="icon-angles-up-down"></svg-loader>
            </combobox-button>

            <transition
                leave-active-class="transition ease-in duration-100"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <combobox-options
                    :class="{ 'py-1': filteredCompetences?.length }"
                    class="absolute z-10 mt-1 max-h-56 w-full overflow-auto rounded-md bg-white text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none dark:bg-darkmode-800 sm:text-sm"
                >
                    <combobox-option
                        v-if="queryOption && !filteredCompetences?.length"
                        v-slot="{ active }"
                        :value="queryOption"
                        as="template"
                    >
                        <li
                            :class="{
                                'bg-primary': active
                            }"
                            class="relative cursor-default select-none py-2 pe-4 ps-10 text-white"
                        >
                            {{ $t('create') }} "{{ queryOption.name }}"
                        </li>
                    </combobox-option>

                    <combobox-option
                        v-for="option in filteredCompetences"
                        :key="option.id"
                        v-slot="{ selected, active }"
                        :value="option"
                        as="template"
                    >
                        <li
                            v-if="option.id"
                            :class="[
                                active ? 'bg-primary text-white' : 'text-gray-900 dark:text-slate-300',
                                'relative cursor-default select-none py-2 pe-9 ps-3'
                            ]"
                        >
                            <div class="flex items-center">
                                <span
                                    :class="[selected ? 'font-semibold' : 'font-normal', 'ms-3 block truncate text-sm']"
                                >
                                    {{ option.name }}
                                </span>
                            </div>

                            <span
                                v-if="selected"
                                :class="[
                                    active ? 'text-white' : 'text-primary',
                                    'absolute inset-y-0 end-0 flex items-center pe-4'
                                ]"
                            >
                                <svg-loader
                                    v-if="active"
                                    aria-hidden="true"
                                    class="h-5 w-5 fill-white"
                                    name="icon-check"
                                ></svg-loader>
                                <svg-loader
                                    v-else
                                    aria-hidden="true"
                                    class="h-5 w-5 fill-primary"
                                    name="icon-check"
                                ></svg-loader>
                            </span>
                        </li>
                    </combobox-option>
                </combobox-options>
            </transition>
        </div>
    </combobox>
</template>
