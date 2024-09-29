<script lang="ts" setup>
import { ComboboxOption, ComboboxOptions } from '@headlessui/vue'
import type { Hits } from 'meilisearch'

import SvgLoader from '@/Components/SvgLoader.vue'
import TheNoResultsFound from '@/Components/top-bar/search/TheNoResultsFound.vue'

import { isEmpty } from '@/utils/helper'
import { $t } from '@/utils/i18n'

defineProps<{
    options: Hits
    querySearch: string
}>()
</script>

<template>
    <ComboboxOptions class="">
        <div v-if="isEmpty(options) && querySearch !== ''">
            <the-no-results-found></the-no-results-found>
        </div>

        <template v-for="(group, groupName) in options" :key="groupName">
            <div v-if="group.length > 0" class="mb-2 font-medium ltr:capitalize rtl:font-semibold">
                {{ $t(`search.${options[groupName][0].index}`) }}
            </div>

            <ComboboxOption v-for="option in group" :key="option.id" v-slot="{ active }" :value="option">
                <div
                    :class="[
                        'mb-1 flex cursor-pointer items-center py-1',
                        {
                            '-mx-1 rounded-md bg-slate-200 px-1 dark:bg-darkmode-300': active
                        }
                    ]"
                >
                    <div
                        v-if="option.icon"
                        :class="option.icon.color"
                        class="flex h-8 w-8 items-center justify-center rounded-full"
                    >
                        <svg-loader :name="option.icon.icon" class="w-h h-4"></svg-loader>
                    </div>

                    <div v-else class="image-fit h-8 w-8">
                        <img :alt="option.title" :src="option.image" class="rounded-full" />
                    </div>

                    <div class="ms-3 ltr:capitalize">
                        {{ option.title }}
                    </div>

                    <div v-if="option.hint" class="ms-auto w-48 truncate text-end text-xs text-slate-500">
                        {{ option.hint }}
                    </div>
                </div>
            </ComboboxOption>
        </template>
    </ComboboxOptions>
</template>
