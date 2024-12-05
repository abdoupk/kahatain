<script lang="ts" setup>
import { ref } from 'vue'

import BaseFormInput from '@/Components/Base/form/BaseFormInput.vue'
import BaseTippy from '@/Components/Base/tippy/BaseTippy.vue'
import FamilyAddressSelector from '@/Components/Global/TheAddressField/TheFamilyAddressSelector.vue'
import SvgLoader from '@/Components/SvgLoader.vue'

import { $t } from '@/utils/i18n'

defineProps<{
    select_location_label: string
}>()

const address = defineModel('address')

const location = defineModel('location')

const showMapModalStatus = ref(false)

const showMapModal = () => {
    showMapModalStatus.value = true
}
</script>

<template>
    <div class="flex w-full items-center">
        <base-form-input
            id="address"
            v-model="address"
            placeholder="حي الحياة تجزئة ب رقم '89' البيض"
            type="text"
        ></base-form-input>

        <base-tippy :content="$t(select_location_label)" class="ms-2">
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
