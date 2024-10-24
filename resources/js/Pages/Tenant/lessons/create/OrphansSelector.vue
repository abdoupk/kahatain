<script lang="ts" setup>
import type { OrphanType } from '@/types/families'

import { useLessonsStore } from '@/stores/lessons'
import { onMounted, ref } from 'vue'

import BaseVueSelect from '@/Components/Base/vue-select/BaseVueSelect.vue'

import { $t } from '@/utils/i18n'

const loadingSearchOrphans = ref(false)

const lessonsStore = useLessonsStore()

const props = defineProps<{
    academic_level_id: number
    quota: number
    orphans: OrphanType[]
}>()

const orphans = ref(props.orphans)

const selectedOrphans = defineModel('selectedOrphans')

const limitText = (count: string) => {
    return $t('vue_select_limit_text', { count })
}

const asyncFind = (search: string) => {
    loadingSearchOrphans.value = true

    lessonsStore
        .getOrphans(search, props.academic_level_id)
        .then((res) => {
            orphans.value = res.data
        })
        .finally(() => (loadingSearchOrphans.value = false))
}

onMounted(() => {
    if (orphans.value) {
        selectedOrphans.value = orphans.value
    }
})
</script>

<template>
    <base-vue-select
        id="orphans"
        v-model:value="selectedOrphans"
        :allow-empty="true"
        :clear-on-select="false"
        :close-on-select="false"
        :hide-selected="true"
        :internal-search="false"
        :limitText="limitText"
        :loading="loadingSearchOrphans"
        :max="quota"
        :options="orphans"
        :placeholder="$t('auth.placeholders.tomselect', { attribute: $t('the_orphans') })"
        :searchable="true"
        :show-no-results="true"
        class="h-full w-full"
        label="name"
        limit="3"
        multiple
        open-direction="bottom"
        track-by="id"
        @search-change="asyncFind"
    >
    </base-vue-select>
</template>
