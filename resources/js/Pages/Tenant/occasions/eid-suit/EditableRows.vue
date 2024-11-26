<script lang="ts" setup>
import type { EidSuitOrphansResource } from '@/types/types'

import EditableMemeberCell from '@/Pages/Tenant/occasions/eid-suit/EditableMemeberCell.vue'
import EditableRow from '@/Pages/Tenant/occasions/eid-suit/EditableRow.vue'

import TheTableTd from '@/Components/Global/DataTable/TheTableTd.vue'
import SvgLoader from '@/Components/Global/SvgLoader.vue'

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
    ></editable-row>

    <editable-row
        :load-options="loadShopOwnerPhoneNumbers"
        :orphan
        class="text-center"
        field="clothes_shop_phone_number"
    ></editable-row>

    <editable-row :load-options="loadShopOwnerNames" :orphan class="text-center" field="shoes_shop_name"></editable-row>

    <editable-row
        :load-options="loadShopOwnerPhoneNumbers"
        :orphan
        class="text-center"
        field="shoes_shop_phone_number"
    ></editable-row>

    <editable-memeber-cell :orphan></editable-memeber-cell>

    <editable-row :orphan field="note"></editable-row>

    <the-table-td>
        <svg-loader class="h-5 w-5" name="icon-map-location-dot"></svg-loader>
    </the-table-td>
</template>
