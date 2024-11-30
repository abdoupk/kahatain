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

const emit = defineEmits(['showLocationAddressModal'])

const handleClick = () => {
    emit('showLocationAddressModal', {
        orphan_id: props.orphan.orphan.id,
        address: props.orphan.eid_suit[addressField.value],
        location: props.orphan.eid_suit[locationField.value],
        shop_type: props.shopType
    })
}
</script>

<template>
    <div class="flex items-center justify-center">
        <svg-loader
            class="h-5 w-5 cursor-pointer"
            name="icon-map-location-dot"
            @click.prevent="handleClick"
        ></svg-loader>
    </div>
</template>
