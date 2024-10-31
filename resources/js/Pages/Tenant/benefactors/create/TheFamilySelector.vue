<script lang="ts" setup>
import type { FamilyType } from '@/types/families'

import { useFamiliesStore } from '@/stores/families'
import { defineAsyncComponent, onMounted, ref } from 'vue'

const BaseVueSelect = defineAsyncComponent(() => import('@/Components/Base/vue-select/BaseVueSelect.vue'))

const props = defineProps<{
    family: string
}>()

const family = ref(props.family)

const selectedFamily = defineModel('selectedFamily')

const loadingSearchFamily = ref(false)

const familiesStore = useFamiliesStore()

const families = ref<FamilyType[]>([])

const asyncFind = (search: string) => {
    loadingSearchFamily.value = true

    familiesStore
        .searchFamilies(search)
        .then((res) => {
            families.value = res
        })
        .finally(() => (loadingSearchFamily.value = false))
}

onMounted(() => {
    if (families.value) {
        selectedFamily.value = family.value
    }
})
</script>

<template>
    <base-vue-select
        id="families"
        v-model:value="selectedFamily"
        :allow-empty="false"
        :clear-on-select="false"
        :hide-selected="true"
        :internal-search="false"
        :loading="loadingSearchFamily"
        :options="families"
        :placeholder="$t('auth.placeholders.tomselect', { attribute: $t('the_families') })"
        :searchable="true"
        :show-no-results="true"
        class="h-full w-full"
        label="name"
        open-direction="bottom"
        track-by="id"
        @search-change="asyncFind"
    >
    </base-vue-select>
</template>
