<script lang="ts" setup>
import type { EidSuitOrphansResource } from '@/types/types'

import EditableRow from '@/Pages/Tenant/occasions/eid-suit/EditableRow.vue'

import TheTableTd from '@/Components/Global/DataTable/TheTableTd.vue'
import SvgLoader from '@/Components/Global/SvgLoader.vue'

defineProps<{
    orphan: EidSuitOrphansResource
}>()
</script>

<template>
    <editable-row :orphan class="text-center" field="clothes_shop_name"></editable-row>

    <editable-row :orphan class="text-center" field="clothes_shop_phone_number"></editable-row>

    <editable-row :orphan class="text-center" field="shoes_shop_name"></editable-row>

    <editable-row :orphan class="text-center" field="shoes_shop_phone_number"></editable-row>

    <!--    <the-table-td>-->
    <!--        <members-filter-drop-down-->
    <!--            :value="selectedOrphan.orphan_id === orphan.id ? selectedOrphan.designated_member : ''"-->
    <!--            class="!w-40"-->
    <!--            @update:value="handleSelectDesignatedMember(orphan.id, $event)"-->
    <!--        ></members-filter-drop-down>-->
    <!--    </the-table-td>-->

    <editable-row :orphan field="note"></editable-row>

    <the-table-td>
        <svg-loader class="h-5 w-5" name="icon-map-location-dot"></svg-loader>
    </the-table-td>
</template>
