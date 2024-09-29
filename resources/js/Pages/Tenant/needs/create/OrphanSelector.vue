<script lang="ts" setup>
import type { OrphanType } from '@/types/families'

import { useOrphansStore } from '@/stores/orphans'
import { onMounted, ref } from 'vue'

import BaseVueSelect from '@/Components/Base/vue-select/BaseVueSelect.vue'

const props = defineProps<{
    orphan: string
}>()

const orphan = ref(props.orphan)

const selectedOrphan = defineModel('selectedOrphan', { default: '' })

const loadingSearchOrphan = ref(false)

const orphansStore = useOrphansStore()

const orphans = ref<OrphanType[]>([])

const asyncFind = (search: string) => {
    loadingSearchOrphan.value = true

    orphansStore
        .searchOrphans(search)
        .then((res) => {
            orphans.value = res
        })
        .finally(() => (loadingSearchOrphan.value = false))
}

onMounted(() => {
    if (orphans.value) {
        selectedOrphan.value = orphan.value
    }
})
</script>

<template>
    <base-vue-select
        id="orphans"
        v-model:value="selectedOrphan"
        :allow-empty="false"
        :clear-on-select="false"
        :hide-selected="true"
        :internal-search="false"
        :loading="loadingSearchOrphan"
        :options="orphans"
        :placeholder="$t('auth.placeholders.tomselect', { attribute: $t('the_orphans') })"
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
