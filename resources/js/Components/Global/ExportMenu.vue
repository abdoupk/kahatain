<script lang="ts" setup>
import type { IndexParams } from '@/types/types'

import print from 'print-js'
import { ref } from 'vue'

import BaseButton from '@/Components/Base/button/BaseButton.vue'
import BaseMenu from '@/Components/Base/headless/Menu/BaseMenu.vue'
import BaseMenuButton from '@/Components/Base/headless/Menu/BaseMenuButton.vue'
import BaseMenuItem from '@/Components/Base/headless/Menu/BaseMenuItem.vue'
import BaseMenuItems from '@/Components/Base/headless/Menu/BaseMenuItems.vue'
import SpinnerButtonLoader from '@/Components/Global/SpinnerButtonLoader.vue'
import SvgLoader from '@/Components/Global/SvgLoader.vue'

import { formatUrl } from '@/utils/helper'

const props = defineProps<{
    exportPdfUrl: string
    exportXlsxUrl: string
    params: IndexParams
}>()

const printStarting = ref<boolean>(false)

const printPdf = () => {
    print({
        printable: formatUrl(props.exportPdfUrl),
        type: 'pdf',
        onLoadingStart: () => {
            printStarting.value = true
        },
        onLoadingEnd: () => {
            printStarting.value = false
        }
    })
}
</script>

<template>
    <base-menu>
        <base-menu-button :as="BaseButton" class="!box px-2">
            <span class="flex h-5 w-5 items-center justify-center">
                <svg-loader class="h-5 w-5 fill-current" name="icon-file-export" />
            </span>
        </base-menu-button>

        <base-menu-items class="w-48" placement="bottom-start">
            <base-menu-item
                :class="{ '!cursor-not-allowed opacity-80': printStarting }"
                :disabled="printStarting"
                as="button"
                @click.prevent="printPdf"
            >
                <svg-loader class="me-2 h-4 w-4 fill-current" name="icon-print"></svg-loader>

                {{ $t('print') }}

                <spinner-button-loader :show="printStarting" class="ms-auto fill-current"></spinner-button-loader>
            </base-menu-item>

            <base-menu-item :href="formatUrl(exportXlsxUrl)" as="a">
                <svg-loader class="me-2 h-4 w-4 fill-current" name="icon-file-excel"></svg-loader>

                {{ $t('export', { type: 'excel' }) }}
            </base-menu-item>

            <base-menu-item :href="formatUrl(exportPdfUrl)" as="a">
                <svg-loader class="me-2 h-4 w-4 fill-current" name="icon-file-pdf"></svg-loader>

                {{ $t('export', { type: 'pdf' }) }}
            </base-menu-item>
        </base-menu-items>
    </base-menu>
</template>
