<script lang="ts" setup>
import { useSettingsStore } from '@/stores/settings'
import { Combobox, ComboboxInput, Dialog as HeadlessDialog, TransitionRoot } from '@headlessui/vue'
import { router } from '@inertiajs/vue3'
import { computedEager } from '@vueuse/core'
import type { Hit } from 'meilisearch'
import { twMerge } from 'tailwind-merge'
import { defineAsyncComponent, onMounted, onUnmounted, ref, watch } from 'vue'

import { search } from '@/utils/search'

const BaseFormInput = defineAsyncComponent(() => import('@/Components/Base/form/BaseFormInput.vue'))

const BaseDialogPanel = defineAsyncComponent(() => import('@/Components/Base/headless/Dialog/BaseDialogPanel.vue'))

const SvgLoader = defineAsyncComponent(() => import('@/Components/Global/SvgLoader.vue'))

const TheResults = defineAsyncComponent(() => import('@/Components/top-bar/search/TheResults.vue'))

const querySearch = ref('')

const open = ref(false)

const settingStore = useSettingsStore()

const computedTheme = computedEager(() => {
    if (settingStore.layout === 'top_menu') {
        return true
    }

    return ['enigma', 'icewall'].includes(settingStore.theme)
})

const results = ref<Hit[]>([])

watch(
    () => querySearch.value,
    async (querySearch: string) => {
        if (querySearch != '') await search(querySearch).then((res) => (results.value = res.map((r) => r.hits)))
    },
    { immediate: true }
)

function onKeydown(event: KeyboardEvent) {
    if (event.key == 'k' && (event.metaKey || event.ctrlKey)) {
        event.preventDefault()

        open.value = !open.value
    }
}

onMounted(() => {
    window.addEventListener('keydown', onKeydown)
})

onUnmounted(() => {
    window.removeEventListener('keydown', onKeydown)
})

const selectedOption = ref<Hit | null>(null)

watch(
    () => selectedOption.value,
    (value) => {
        querySearch.value = ''

        document.getElementById('search')?.blur()

        router.visit(value?.url, {
            method: 'get',
            // TODO change if has same pathname change else dont usePage.url
            preserveState: false
        })

        open.value = false
    }
)
</script>

<template>
    <a class="relative text-slate-600 sm:hidden" role="button" @click="open = true">
        <svg-loader
            :class="{ 'fill-white/70': computedTheme }"
            class="h-5 w-5 dark:fill-slate-500"
            name="icon-search"
        ></svg-loader>
    </a>
    <transition-root :show="open" appear as="div" @after-enter="() => (querySearch = '')">
        <headless-dialog class="relative z-[60]" @close="open = false">
            <base-dialog-panel class="rounded-xl" size="md">
                <Combobox
                    v-model="selectedOption"
                    as="div"
                    class="divide-y divide-gray-100 overflow-hidden rounded-xl dark:divide-darkmode-400"
                >
                    <div class="flex items-center px-4">
                        <svg-loader class="h-6 w-6 text-slate-500" name="icon-search"></svg-loader>

                        <ComboboxInput
                            id="search"
                            v-model="querySearch"
                            :as="BaseFormInput"
                            :class="
                                twMerge(
                                    'h-12 border-transparent bg-transparent shadow-none ring-0 ring-black/5 focus:border-transparent focus:ring-0 dark:bg-transparent'
                                )
                            "
                            :placeholder="$t('Search...')"
                            @keydown.esc.prevent="() => (querySearch = '')"
                        />
                    </div>
                    <div
                        :class="querySearch.length > 0 ? 'pt-5' : ''"
                        class="box scrollbar-hidden max-h-96 overflow-y-auto px-5"
                    >
                        <the-results :options="results" :querySearch></the-results>
                    </div>
                </Combobox>
            </base-dialog-panel>
        </headless-dialog>
    </transition-root>
</template>
