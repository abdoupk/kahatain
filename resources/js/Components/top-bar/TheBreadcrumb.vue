<script lang="ts" setup>
import { usePage } from '@inertiajs/vue3'
import { computedEager } from '@vueuse/core'
import { defineAsyncComponent } from 'vue'

import { $t } from '@/utils/i18n'

const BaseBreadCrumb = defineAsyncComponent(() => import('@/Components/Base/Breadcrumb/BaseBreadcrumb.vue'))

const BaseBreadCrumbLink = defineAsyncComponent(() => import('@/Components/Base/Breadcrumb/BaseBreadcrumbLink.vue'))

const { light = false } = defineProps<{ light?: boolean }>()

const breadcrumbs = computedEager(() => {
    // TODO getOnly link without https
    const pathArray = usePage().url.split('/').filter(Boolean)

    const breadCrumbs = []

    let href = ''

    let prevText = ''

    for (const path of pathArray) {
        href += `/${path}`

        const resolvedHref = href === '/' ? '/dashboard' : href

        if (prevText === 'details') {
            continue
        } else if (prevText !== 'edit' && prevText !== 'create' && prevText !== 'show') {
            breadCrumbs.push({
                href: path === 'occasions' || (path === 'details' && prevText === 'archive') ? '#' : resolvedHref,
                active: path !== pathArray[pathArray.length - 1],
                text: $t('breadcrumb.' + path.split(/[?#]/)[0])
            })
        } else {
            breadCrumbs[breadCrumbs.length - 1].active = false
        }

        prevText = path
    }

    return breadCrumbs
})
</script>

<template>
    <base-bread-crumb :light="light" class="-intro-x me-auto hidden sm:flex">
        <base-bread-crumb-link
            v-for="(breadcrumb, index) in breadcrumbs"
            :key="index"
            :active="breadcrumb.active"
            :href="breadcrumb.href"
            :index="index"
            :light="light"
        >
            {{ breadcrumb.text }}
        </base-bread-crumb-link>
    </base-bread-crumb>
</template>
