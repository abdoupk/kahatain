<script lang="ts" setup>
import { useSponsorshipsStore } from '@/stores/sponsorships'
import { onMounted, ref } from 'vue'

import BaseListBox from '@/Components/Base/headless/Listbox/BaseListBox.vue'

import { $t } from '@/utils/i18n'

const value = defineModel('value')

const sponsorshipsStore = useSponsorshipsStore()

const data = ref([])

onMounted(async () => {
    await sponsorshipsStore.getRamadanBasketCategories().then((res) => {
        data.value.push({
            id: $t('dont_benefit'),
            name: $t('dont_benefit')
        })

        data.value.push(...res.categories.map((name) => ({ id: name, name })))
    })
})
</script>

<template>
    <base-list-box v-model="value" :options="data" class="mt-2" label-key="name" value-key="id"></base-list-box>
</template>
