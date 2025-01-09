<script lang="ts" setup>
import NoResultsFound from '@/Components/Global/NoResultsFound.vue'
import TheGallery from '@/Components/Global/TheGallery.vue'
import ThePdfViewer from '@/Components/Global/ThePdfViewer.vue'

import { $t } from '@/utils/i18n'

defineProps<{
    pdf: string
    images: {
        original: string
        thumb: string
        width: number
        height: number
    }[]
    noFilesMessage: string
}>()
</script>

<template>
    <template v-if="pdf || images.length">
        <!-- BEGIN: Files Images -->
        <div v-if="images.length" class="intro-y box col-span-12 @container 2xl:col-span-6">
            <div class="flex items-center border-b border-slate-200/60 px-5 py-5 dark:border-darkmode-400 sm:py-3">
                <h2 class="me-auto text-xl font-bold">{{ $t('upload-files.files') }} ({{ $t('photos') }})</h2>
            </div>

            <div class="w-full p-5">
                <the-gallery :images gallery-id="images"></the-gallery>
            </div>
        </div>
        <!-- END: Files Images -->

        <!-- BEGIN: Files PDF -->
        <div v-if="pdf" class="intro-y box col-span-12 @container 2xl:col-span-6">
            <div class="flex items-center border-b border-slate-200/60 px-5 py-5 dark:border-darkmode-400 sm:py-3">
                <h2 class="me-auto text-xl font-bold">{{ $t('upload-files.files') }} (PDF)</h2>
            </div>

            <div class="w-full p-5">
                <the-pdf-viewer :pdf-url="pdf"></the-pdf-viewer>
            </div>
        </div>
        <!-- END: Files PDF -->
    </template>

    <!-- BEGIN: No Files -->
    <div v-else class="intro-y box col-span-12 @container 2xl:col-span-6">
        <div class="w-full p-5">
            <div class="intro-x mt-12 flex flex-col items-center justify-center">
                <no-results-found>
                    {{ noFilesMessage }}
                </no-results-found>
            </div>
        </div>
    </div>
    <!-- END: No Files   -->
</template>
