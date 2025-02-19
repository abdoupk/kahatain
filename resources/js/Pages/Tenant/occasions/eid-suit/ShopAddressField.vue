<script lang="ts" setup>
import { ref } from 'vue'

import BaseCombobox from '@/Components/Base/headless/Combobox/BaseCombobox.vue'
import BaseTippy from '@/Components/Base/tippy/BaseTippy.vue'
import FamilyAddressSelector from '@/Components/Global/TheAddressField/TheFamilyAddressSelector.vue'
import SvgLoader from '@/Components/SvgLoader.vue'

import { loadShopOwnerAddresses } from '@/utils/helper'
import { $t } from '@/utils/i18n'

defineProps<{
    select_location_label: string
}>()

const address = defineModel('address', { default: '' })

const location = defineModel('location', { default: null })

const showMapModalStatus = ref(false)

const showMapModal = () => {
    showMapModalStatus.value = true
}
</script>

<template>
    <div class="flex w-full items-center">
        <base-combobox
            class="w-full"
            v-model="address"
            :load-options="loadShopOwnerAddresses"
            :options="[]"
            create-option
        ></base-combobox>

        <base-tippy :content="$t(select_location_label)" class="ms-2 mt-3">
            <button type="button" @click.prevent="showMapModal">
                <svg-loader class="h-6 w-6" name="icon-location"></svg-loader>
            </button>
        </base-tippy>
    </div>

    <family-address-selector
        :location
        :open="showMapModalStatus"
        :title="$t('select_location')"
        @close="showMapModalStatus = false"
        @set-location="location = $event"
    ></family-address-selector>
</template>
