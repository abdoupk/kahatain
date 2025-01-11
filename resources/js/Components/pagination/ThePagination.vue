<script lang="ts" setup>
import { usePage } from '@inertiajs/vue3'
import { computedEager } from '@vueuse/core'

import BasePagination from '@/Components/Base/pagination/BasePagination.vue'
import BasePaginationLink from '@/Components/Base/pagination/BasePaginationLink.vue'
import SvgLoader from '@/Components/SvgLoader.vue'
import PaginationPage from '@/Components/pagination/atom/PaginationPage.vue'

const {
    pages = 0,
    rangeSize = 1,
    modelValue = 1,
    activeColor = 'currentColor',
    hideFirstButton = false,
    hideLastButton = false
} = defineProps<{
    pages?: number
    rangeSize?: number
    modelValue?: number
    activeColor?: string
    hideFirstButton?: boolean
    hideLastButton?: boolean
}>()

const emit = defineEmits(['update:modelValue'])

// TODO get value from inertia or store or from HTML Tag
const dir = usePage().props.language !== 'ar' ? 'ltr' : 'rtl'

const pagination = computedEager((): (number | null)[] => {
    const res = []

    const minPaginationElems = 3 + rangeSize * 2

    let rangeStart = pages <= minPaginationElems ? 1 : modelValue - rangeSize

    let rangeEnd = pages <= minPaginationElems ? pages : modelValue + rangeSize

    rangeEnd = rangeEnd > pages ? pages : rangeEnd

    rangeStart = rangeStart < 1 ? 1 : rangeStart

    if (pages > minPaginationElems) {
        const isStartBoundaryReached = rangeStart - 1 < 3

        const isEndBoundaryReached = pages - rangeEnd < 3

        if (isStartBoundaryReached) {
            rangeEnd = minPaginationElems - 2

            for (let i = 1; i < rangeStart; i++) {
                res.push(i)
            }
        } else {
            res.push(1)

            res.push(null)
        }

        if (isEndBoundaryReached) {
            rangeStart = pages - (minPaginationElems - 3)

            for (let i = rangeStart; i <= pages; i++) {
                res.push(i)
            }
        } else {
            for (let i = rangeStart; i <= rangeEnd; i++) {
                res.push(i)
            }

            res.push(null)

            res.push(pages)
        }
    } else {
        for (let i = rangeStart; i <= rangeEnd; i++) {
            res.push(i)
        }
    }

    return res
})

function updatePageHandler(params: number) {
    emit('update:modelValue', params)
}

// Controls
const isPrevControlsActive = computedEager((): boolean => {
    return modelValue > 1
})

const isNextControlsActive = computedEager((): boolean => {
    return modelValue < pages
})

function goToFirst(): void {
    if (isPrevControlsActive.value) {
        emit('update:modelValue', 1)
    }
}

function goToPrev(): void {
    if (isPrevControlsActive.value) {
        emit('update:modelValue', modelValue - 1)
    }
}

function goToLast(): void {
    if (isNextControlsActive.value) {
        emit('update:modelValue', pages)
    }
}

function goToNext(): void {
    if (isNextControlsActive.value) {
        emit('update:modelValue', modelValue + 1)
    }
}
</script>

<template>
    <base-pagination class="w-full sm:me-auto sm:w-auto">
        <base-pagination-link v-if="!hideFirstButton" @click="goToFirst">
            <svg-loader v-if="dir === 'ltr'" class="h-5 w-5 fill-current p-1" name="icon-chevrons-left"></svg-loader>

            <svg-loader v-else class="h-5 w-5 fill-current p-1" name="icon-chevrons-right"></svg-loader>
        </base-pagination-link>

        <base-pagination-link @click="goToPrev">
            <svg-loader v-if="dir === 'ltr'" class="h-5 w-5 fill-current p-1" name="icon-chevron-left"></svg-loader>

            <svg-loader v-else class="h-5 w-5 fill-current p-1" name="icon-chevron-right"></svg-loader>
        </base-pagination-link>

        <pagination-page
            v-for="page in pagination"
            :key="`pagination-page-${page}`"
            :active-color="activeColor"
            :current="modelValue"
            :page="page"
            @update="updatePageHandler"
        />

        <base-pagination-link @click="goToNext">
            <svg-loader v-if="dir === 'ltr'" class="h-5 w-5 fill-current p-1" name="icon-chevron-right"></svg-loader>

            <svg-loader v-else class="h-5 w-5 fill-current p-1" name="icon-chevron-left"></svg-loader>
        </base-pagination-link>

        <base-pagination-link v-if="!hideLastButton" @click="goToLast">
            <svg-loader v-if="dir === 'ltr'" class="h-5 w-5 fill-current p-1" name="icon-chevrons-right"></svg-loader>

            <svg-loader v-else class="h-5 w-5 fill-current p-1" name="icon-chevrons-left"></svg-loader>
        </base-pagination-link>
    </base-pagination>
</template>
