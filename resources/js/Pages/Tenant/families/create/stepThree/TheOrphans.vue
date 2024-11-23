<script lang="ts" setup>
import { useCreateFamilyStore } from '@/stores/create-family'

import OrphanForm from '@/Pages/Tenant/families/create/stepThree/OrphanForm.vue'

import SvgLoader from '@/Components/SvgLoader.vue'

const createFamilyStore = useCreateFamilyStore()

const removeOrphan = (index: number) => {
    if (index > 0) {
        createFamilyStore.family.orphans.splice(index, 1)
    }
}
</script>

<template>
    <template v-for="index in createFamilyStore.family.orphans.length" :key="`orphan-${index}`">
        <div class="my-5 flex">
            <p class="text-base font-medium">
                {{ $t('child no', { no: String(index + 1) }) }}
            </p>

            <button class="me-2 ms-auto"></button>

            <a
                :class="{ hidden: createFamilyStore.family.orphans.length === 0 }"
                class="ms-2 inline-block !outline-none focus-visible:!rounded-sm focus-visible:!outline-red-300/70"
                href="#"
                @click.prevent="removeOrphan(index)"
            >
                <svg-loader class="fill-danger" name="icon-trash-can"></svg-loader>
            </a>
        </div>

        <orphan-form :form :index></orphan-form>
    </template>
</template>
