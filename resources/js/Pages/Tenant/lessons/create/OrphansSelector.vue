<script lang="ts" setup>
import { useLessonsStore } from '@/stores/lessons'
import { onMounted, ref, watch } from 'vue'

import BaseListBox from '@/Components/Base/headless/Listbox/BaseListBox.vue'

import { $t } from '@/utils/i18n'

const lessonsStore = useLessonsStore()

const props = defineProps<{
    academic_level_id: number
    quota: number
}>()

const orphans = defineModel('orphans')

const searchedOrphans = ref([])

onMounted(async () => {
    await lessonsStore.getOrphans('', props.academic_level_id).then((res) => {
        searchedOrphans.value = res.data
    })
})

watch(
    () => props.academic_level_id,
    async (value) => {
        await lessonsStore.getOrphans('', value).then((res) => {
            orphans.value = []

            searchedOrphans.value = res.data
        })
    }
)
</script>

<template>
    <base-list-box
        v-model="orphans"
        :model-value="orphans"
        :options="searchedOrphans"
        :placeholder="$t('auth.placeholders.tomselect', { attribute: $t('the_orphans') })"
        label-key="name"
        multiple
        value-key="id"
    ></base-list-box>
</template>
