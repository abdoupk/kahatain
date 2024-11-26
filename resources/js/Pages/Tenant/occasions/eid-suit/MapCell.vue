<script lang="ts" setup>
import { EidSuitOrphansResource } from '@/types/types'

import { ref } from 'vue'

import SvgLoader from '@/Components/Global/SvgLoader.vue'

const props = defineProps<{
    orphan: EidSuitOrphansResource
    shopType: 'clothes' | 'shoes'
}>()

const orphan = ref(props.orphan)

const addressField = ref(props.shopType + '_shop_address')

const locationField = ref(props.shopType + '_shop_location')

const showLocationAddressModal = ref(false)

const emit = defineEmits(['showLocationAddressModal'])
</script>

<template>
    <svg-loader
        v-if="!orphan.eid_suit[addressField] && !orphan.eid_suit[locationField]?.lang"
        class="h-5 w-5 cursor-pointer"
        name="icon-location"
        @click.prevent="emit('showLocationAddressModal')"
    ></svg-loader>

    <svg-loader v-else class="h-5 w-5 cursor-pointer" name="icon-map-location-dot"></svg-loader>
</template>
