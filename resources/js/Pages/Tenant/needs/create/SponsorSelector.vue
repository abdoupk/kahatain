<script lang="ts" setup>
import type { SponsorType } from '@/types/families'

import { useSponsorsStore } from '@/stores/sponsors'
import { onMounted, ref } from 'vue'

import BaseVueSelect from '@/Components/Base/vue-select/BaseVueSelect.vue'

const props = defineProps<{
    sponsor: string
}>()

const sponsor = ref(props.sponsor)

const selectedSponsor = defineModel('selectedSponsor')

const loadingSearchSponsor = ref(false)

const sponsorsStore = useSponsorsStore()

const sponsors = ref<SponsorType[]>([])

const asyncFind = (search: string) => {
    loadingSearchSponsor.value = true

    sponsorsStore
        .searchSponsors(search)
        .then((res) => {
            sponsors.value = res
        })
        .finally(() => (loadingSearchSponsor.value = false))
}

onMounted(() => {
    if (sponsors.value) {
        selectedSponsor.value = sponsor.value
    }
})
</script>

<template>
    <base-vue-select
        id="sponsors"
        v-model:value="selectedSponsor"
        :allow-empty="false"
        :clear-on-select="false"
        :hide-selected="true"
        :internal-search="false"
        :loading="loadingSearchSponsor"
        :options="sponsors"
        :placeholder="$t('auth.placeholders.tomselect', { attribute: $t('the_sponsors') })"
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
