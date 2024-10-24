<script lang="ts" setup>
import { useBenefactorsStore } from '@/stores/benefactors'
import type { BenefactorType } from '@/types'
import { onMounted, ref } from 'vue'

import BaseVueSelect from '@/Components/Base/vue-select/BaseVueSelect.vue'

import { $t } from '@/utils/i18n'

const props = defineProps<{
    benefactor: string
}>()

const benefactor = ref(props.benefactor)

const selectedBenefactor = defineModel('selectedBenefactor', { default: '' })

const loadingSearchBenefactor = ref(false)

const benefactorsStore = useBenefactorsStore()

const benefactors = ref<BenefactorType[]>([])

const asyncFind = (search: string) => {
    loadingSearchBenefactor.value = true

    benefactorsStore.searchBenefactors(search).finally(() => (loadingSearchBenefactor.value = false))
}

onMounted(() => {
    if (benefactors.value) {
        selectedBenefactor.value = benefactor.value
    }
})
</script>

<template>
    <base-vue-select
        id="benefactor"
        v-model:value="selectedBenefactor"
        :allow-empty="false"
        :clear-on-select="false"
        :hide-selected="true"
        :internal-search="false"
        :loading="loadingSearchBenefactor"
        :options="benefactorsStore.benefactors"
        :placeholder="$t('auth.placeholders.tomselect', { attribute: $t('the_benefactors') })"
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
