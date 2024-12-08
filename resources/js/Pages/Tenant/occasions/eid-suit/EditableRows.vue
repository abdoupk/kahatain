<script lang="ts" setup>
import type { EidSuitOrphansResource } from '@/types/types'

import EditableMemberCell from '@/Pages/Tenant/occasions/eid-suit/EditableMemberCell.vue'
import EditableRow from '@/Pages/Tenant/occasions/eid-suit/EditableRow.vue'
import MapCell from '@/Pages/Tenant/occasions/eid-suit/MapCell.vue'

import TheTableTd from '@/Components/Global/DataTable/TheTableTd.vue'

import { searchShopOwnerName, searchShopOwnerPhoneNumber } from '@/utils/search'

defineProps<{
    orphan: EidSuitOrphansResource
}>()

function loadShopOwnerNames(query: string, setOptions: (results: { id: string; name: string }[]) => void) {
    searchShopOwnerName(query).then((results) => {
        setOptions(results)
    })
}

function loadShopOwnerPhoneNumbers(query: string, setOptions: (results: { id: string; name: string }[]) => void) {
    searchShopOwnerPhoneNumber(query).then((results) => {
        setOptions(results)
    })
}
</script>

<template>
    <editable-row
        :loadOptions="loadShopOwnerNames"
        :orphan
        class="text-center"
        field="clothes_shop_name"
        @show-success-notification="$emit('showSuccessNotification')"
    ></editable-row>

    <editable-row
        :load-options="loadShopOwnerPhoneNumbers"
        :orphan
        class="text-center"
        field="clothes_shop_phone_number"
        @show-success-notification="$emit('showSuccessNotification')"
    ></editable-row>

    <the-table-td>
        <map-cell
            :orphan
            shop-type="shoes"
            @show-location-address-modal="$emit('showLocationAddressModal', $event)"
        ></map-cell>
    </the-table-td>

    <editable-row
        :load-options="loadShopOwnerNames"
        :orphan
        class="text-center"
        field="shoes_shop_name"
        @show-success-notification="$emit('showSuccessNotification')"
    ></editable-row>

    <editable-row
        :load-options="loadShopOwnerPhoneNumbers"
        :orphan
        class="text-center"
        field="shoes_shop_phone_number"
        @show-success-notification="$emit('showSuccessNotification')"
    ></editable-row>

    <the-table-td>
        <map-cell
            :orphan
            shop-type="shoes"
            @show-location-address-modal="$emit('showLocationAddressModal', $event)"
        ></map-cell>
    </the-table-td>

    <editable-member-cell :orphan></editable-member-cell>

    <editable-row
        :orphan
        field="note"
        @show-success-notification="$emit('showSuccessNotification', $event)"
    ></editable-row>
</template>
