<script lang="ts" setup>
import { Combobox, ComboboxButton, ComboboxInput, TransitionRoot } from '@headlessui/vue'
import { router } from '@inertiajs/vue3'
import type { Hit } from 'meilisearch'
import { twMerge } from 'tailwind-merge'
import { defineAsyncComponent, onMounted, onUnmounted, ref, watch } from 'vue'

import { $t } from '@/utils/i18n'
import { search } from '@/utils/search'

const BaseFormInput = defineAsyncComponent(() => import('@/Components/Base/form/BaseFormInput.vue'))

const SvgLoader = defineAsyncComponent(() => import('@/Components/SvgLoader.vue'))

const TheResults = defineAsyncComponent(() => import('@/Components/top-bar/search/TheResults.vue'))

const options = ref<Hit[]>([])

const selectedOption = ref<Hit | null>(null)

const querySearch = ref('')

watch(
    () => selectedOption.value,
    (value) => {
        querySearch.value = ''

        document.getElementById('search')?.blur()

        router.visit(value?.url, {
            method: 'get',
            preserveState: false
        })
    }
)

watch(
    () => querySearch.value,
    async (query: string) => {
        if (query != '') await search(query).then((res) => (options.value = res.map((r) => r.hits)))
    },
    { immediate: true }
)

function onKeydown(event: KeyboardEvent) {
    const searchInput = document.getElementById('search') as HTMLInputElement

    if (event.key == 'k' && (event.metaKey || event.ctrlKey)) {
        event.preventDefault()

        if (searchInput.value) {
            searchInput?.blur()

            querySearch.value = ''
        } else {
            searchInput?.focus()
        }
    }
}

onMounted(() => {
    window.addEventListener('keydown', onKeydown)
})

onUnmounted(() => window.removeEventListener('keydown', onKeydown))
</script>

<template>
    <div class="relative">
        <Combobox v-model="selectedOption">
            <div class="relative z-50 mt-1">
                <ComboboxInput
                    id="search"
                    v-model="querySearch"
                    :as="BaseFormInput"
                    :class="
                        twMerge(
                            'w-56 rounded-full border-transparent bg-slate-200 pe-8 shadow-none transition-[width] duration-300 ease-in-out focus:w-72 focus:border-transparent dark:bg-darkmode-400'
                        )
                    "
                    :placeholder="$t('Search...')"
                    @blur="
                        () => {
                            querySearch = ''

                            selectedOption = null
                        }
                    "
                    @keydown.esc.prevent="() => (querySearch = '')"
                />

                <ComboboxButton class="absolute inset-y-0 end-0 flex items-center pe-2">
                    <svg-loader
                        class="absolute inset-y-0 end-0 my-auto me-3 h-5 w-5 text-slate-600 dark:text-slate-500 rtl:rotate-90"
                        name="icon-search"
                    ></svg-loader>
                </ComboboxButton>

                <transition-root
                    :show="querySearch.length > 0"
                    as="template"
                    enter="transition-all ease-linear duration-150"
                    enter-from="mt-5 invisible opacity-0 translate-y-1"
                    enter-to="mt-[3px] visible opacity-100 translate-y-0"
                    entered="mt-[3px]"
                    leave="transition-all ease-linear duration-150"
                    leave-from="mt-[3px] visible opacity-100 translate-y-0"
                    leave-to="mt-5 invisible opacity-0 translate-y-1"
                    @after-leave="querySearch = ''"
                >
                    <div class="absolute end-0 z-10 mt-[3px]">
                        <the-results
                            :options
                            :querySearch
                            class="box scrollbar-hidden max-h-[500px] w-[450px] overflow-y-auto scroll-smooth px-5 pt-5"
                        ></the-results>
                    </div>
                </transition-root>
            </div>
        </Combobox>
    </div>
</template>
