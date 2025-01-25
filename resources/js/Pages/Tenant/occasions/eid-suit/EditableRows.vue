<script lang="ts" setup>
import type { EidSuitOrphansResource } from '@/types/types'

import EditableMemberCell from '@/Pages/Tenant/occasions/eid-suit/EditableMemberCell.vue'
import EditableRow from '@/Pages/Tenant/occasions/eid-suit/EditableRow.vue'
import MapCell from '@/Pages/Tenant/occasions/eid-suit/MapCell.vue'

import TheTableTd from '@/Components/Global/DataTable/TheTableTd.vue'

import { loadShopOwnerNames, loadShopOwnerPhoneNumbers } from '@/utils/helper'

defineProps<{
    orphan: EidSuitOrphansResource
}>()

const emit = defineEmits(['selectOrphan', 'deselectOrphan'])
</script>

<template>
    <editable-row
        :loadOptions="loadShopOwnerNames"
        :orphan
        class="text-center"
        field="clothes_shop_name"
        @select-orphan="emit('selectOrphan', orphan.orphan.id)"
        @deselect-orphan="emit('deselectOrphan', orphan.orphan.id)"
        @show-success-notification="$emit('showSuccessNotification')"
    ></editable-row>

    <editable-row
        :load-options="loadShopOwnerPhoneNumbers"
        :orphan
        class="text-center"
        field="clothes_shop_phone_number"
        @select-orphan="emit('selectOrphan', orphan.orphan.id)"
        @deselect-orphan="emit('deselectOrphan', orphan.orphan.id)"
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
        @select-orphan="emit('selectOrphan', orphan.orphan.id)"
        @deselect-orphan="emit('deselectOrphan', orphan.orphan.id)"
        @show-success-notification="$emit('showSuccessNotification')"
    ></editable-row>

    <editable-row
        :load-options="loadShopOwnerPhoneNumbers"
        :orphan
        class="text-center"
        field="shoes_shop_phone_number"
        @select-orphan="emit('selectOrphan', orphan.orphan.id)"
        @deselect-orphan="emit('deselectOrphan', orphan.orphan.id)"
        @show-success-notification="$emit('showSuccessNotification')"
    ></editable-row>

    <the-table-td>
        <map-cell
            :orphan
            shop-type="shoes"
            @show-location-address-modal="$emit('showLocationAddressModal', $event)"
        ></map-cell>
    </the-table-td>

    <editable-member-cell :orphan @show-success-notification="$emit('showSuccessNotification')"></editable-member-cell>

    <editable-row
        :orphan
        field="note"
        @select-orphan="emit('selectOrphan', orphan.orphan.id)"
        @deselect-orphan="emit('deselectOrphan', orphan.orphan.id)"
        @show-success-notification="$emit('showSuccessNotification', $event)"
    ></editable-row>
</template>
