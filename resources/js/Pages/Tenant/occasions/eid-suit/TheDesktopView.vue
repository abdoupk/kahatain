<script lang="ts" setup>
import type { EidSuitOrphansResource, IndexParams, PaginationData } from '@/types/types'

import { useOrphansStore } from '@/stores/orphans'
import { Link } from '@inertiajs/vue3'
import { ref, watch } from 'vue'

import InfosEditModal from '@/Pages/Tenant/occasions/eid-suit/InfosEditModal.vue'
import InfosShowModal from '@/Pages/Tenant/occasions/eid-suit/InfosShowModal.vue'

import BaseFormCheckInput from '@/Components/Base/form/form-check/BaseFormCheckInput.vue'
import BaseTable from '@/Components/Base/table/BaseTable.vue'
import BaseTbodyTable from '@/Components/Base/table/BaseTbodyTable.vue'
import BaseTheadTable from '@/Components/Base/table/BaseTheadTable.vue'
import BaseTrTable from '@/Components/Base/table/BaseTrTable.vue'
import BaseTippy from '@/Components/Base/tippy/BaseTippy.vue'
import TheTableTd from '@/Components/Global/DataTable/TheTableTd.vue'
import TheTableTdActions from '@/Components/Global/DataTable/TheTableTdActions.vue'
import TheTableTh from '@/Components/Global/DataTable/TheTableTh.vue'
import SvgLoader from '@/Components/SvgLoader.vue'

import { formatCurrency } from '@/utils/helper'
import { $t, $tc } from '@/utils/i18n'

const props = defineProps<{
    orphans: PaginationData<EidSuitOrphansResource>
    params: IndexParams
    showWarningAlert: boolean
    notifiable: object
}>()

const emit = defineEmits(['sort'])

const orphansStore = useOrphansStore()

const showWarningModal = ref(false)

const showEditModalStatus = ref(false)

const selectedOrphan = ref(null)

const showDetailsModalStatus = ref(false)

const checkAll = ($event) => {
    const orphans = props.orphans.data.map((orphan) => orphan.id)

    if ($event.target.checked) {
        // If checked, add all orphans to selectedFamilies
        if (orphansStore.selectedOrphans.length) {
            // Avoid duplication by filtering out existing ones
            orphansStore.selectedOrphans = [...new Set([...orphansStore.selectedOrphans, ...orphans])]
        } else {
            orphansStore.selectedOrphans = orphans
        }
    } else {
        // If unchecked, remove the current orphans from selectedFamilies
        orphansStore.selectedOrphans = orphansStore.selectedOrphans.filter((id) => !orphans.includes(id))
    }
}

const showEditModal = (id: string) => {
    showEditModalStatus.value = true

    selectedOrphan.value = id

    useOrphansStore().selectedOrphans.push(id)
}

const closeEditModal = () => {
    selectedOrphan.value = null

    useOrphansStore().selectedOrphans.splice(useOrphansStore().selectedOrphans.indexOf(selectedOrphan.value), 1)

    showEditModalStatus.value = false
}

const showDetailsModal = async (id: string) => {
    showDetailsModalStatus.value = true

    await useOrphansStore().getEidSuitInfos(id)
}

watch(
    () => props.showWarningAlert,
    () => {
        if (props.showWarningAlert) {
            showWarningModal.value = true
        }
    }
)
</script>

<template>
    <div class="intro-y !z-30 col-span-12 hidden overflow-x-auto @3xl:block">
        <base-table class="mt-2 border-separate border-spacing-y-[10px]">
            <base-thead-table>
                <base-tr-table>
                    <the-table-th class="text-start">
                        <base-form-check-input
                            :checked="orphansStore.selectedOrphans.length"
                            type="checkbox"
                            @change="checkAll"
                        ></base-form-check-input>
                    </the-table-th>

                    <the-table-th
                        :direction="params.directions && params.directions['name']"
                        class="text-start"
                        sortable
                        @click="emit('sort', 'name')"
                    >
                        {{ $t('the_child') }}
                    </the-table-th>

                    <the-table-th
                        :direction="params.directions && params.directions['pants_size']"
                        class="text-center"
                        sortable
                        @click="emit('sort', 'pants_size')"
                    >
                        {{ $t('pants_size') }}
                    </the-table-th>

                    <the-table-th
                        :direction="params.directions && params.directions['shoes_size']"
                        class="text-center"
                        sortable
                        @click="emit('sort', 'shoes_size')"
                    >
                        {{ $t('shoes_size') }}
                    </the-table-th>

                    <the-table-th
                        :direction="params.directions && params.directions['shirt_size']"
                        class="text-center"
                        sortable
                        @click="emit('sort', 'shirt_size')"
                    >
                        {{ $t('shirt_size') }}
                    </the-table-th>

                    <the-table-th
                        :direction="params.directions && params.directions['birth_date']"
                        class="text-center"
                        sortable
                        @click="emit('sort', 'birth_date')"
                    >
                        {{ $t('age') }}
                    </the-table-th>

                    <the-table-th
                        :direction="params.directions && params.directions['family.income_rate']"
                        class="!w-32 text-center"
                        sortable
                        @click="emit('sort', 'family.income_rate')"
                    >
                        {{ $t('income_rate') }}
                    </the-table-th>

                    <the-table-th
                        :direction="params.directions && params.directions['sponsor.name']"
                        class="text-start"
                        sortable
                        @click="emit('sort', 'sponsor.name')"
                    >
                        {{ $t('the_sponsor') }}
                    </the-table-th>

                    <the-table-th class="text-center">
                        {{ $t('validation.attributes.sponsor.phone_number') }}
                    </the-table-th>

                    <the-table-th class="text-start">
                        {{ $t('validation.attributes.address') }}
                    </the-table-th>

                    <the-table-th class="text-center">
                        {{ $t('actions') }}
                    </the-table-th>
                </base-tr-table>
            </base-thead-table>

            <base-tbody-table>
                <base-tr-table v-for="orphan in orphans.data" :key="orphan.id" class="intro-x">
                    <the-table-td class="w-16">
                        <base-form-check-input
                            v-model="orphansStore.selectedOrphans"
                            :value="orphan.id"
                            type="checkbox"
                        ></base-form-check-input>
                    </the-table-td>

                    <the-table-td class="">
                        <Link
                            :href="route('tenant.orphans.show', orphan.orphan.id)"
                            class="whitespace-nowrap font-medium rtl:!font-semibold"
                        >
                            {{ orphan.orphan.name }}

                            <svg-loader
                                v-if="orphan.eid_suit.completed"
                                class="mb-0.5 ms-1 inline-block h-4 w-4 fill-success"
                                name="icon-check-circle"
                            ></svg-loader>
                        </Link>
                    </the-table-td>

                    <the-table-td class="max-w-40 truncate text-center">
                        {{ orphan.orphan.pants_size }}
                    </the-table-td>

                    <the-table-td class="max-w-40 truncate text-center">
                        {{ orphan.orphan.shoes_size }}
                    </the-table-td>

                    <the-table-td class="max-w-40 truncate text-center">
                        {{ orphan.orphan.shirt_size }}
                    </the-table-td>

                    <the-table-td class="max-w-40 truncate text-center">
                        <span v-if="orphan.orphan.age > 0">{{
                            $tc('age_years', orphan.orphan.age, { count: String(orphan.orphan.age) })
                        }}</span>

                        <span v-else> {{ $t('low_than_one_year') }}</span>
                    </the-table-td>

                    <the-table-td class="text-center">
                        <div class="whitespace-nowrap">
                            {{ formatCurrency(orphan.family.income_rate) }}
                        </div>
                    </the-table-td>

                    <the-table-td class="!min-w-24 !max-w-24 truncate">
                        <Link
                            :href="route('tenant.sponsors.show', orphan.sponsor.id)"
                            class="font-medium rtl:!font-semibold"
                        >
                            <base-tippy :content="orphan.sponsor.name">
                                {{ orphan.sponsor.name }}
                            </base-tippy>
                        </Link>
                    </the-table-td>

                    <the-table-td class="whitespace-nowrap text-center">
                        {{ orphan.sponsor.phone_number }}
                    </the-table-td>

                    <the-table-td class="max-w-40 truncate">
                        <base-tippy :content="orphan.family.address">
                            {{ orphan.family.address }}
                        </base-tippy>

                        <Link
                            :href="route('tenant.zones.index') + `?show=${orphan.family.zone?.id}`"
                            class="mt-0.5 block whitespace-nowrap text-xs text-slate-500"
                        >
                            {{ orphan.family.zone?.name }}
                        </Link>
                    </the-table-td>

                    <the-table-td-actions class="w-fit text-center">
                        <div class="flex items-center justify-center">
                            <a
                                class="me-3 flex items-center"
                                href="javascript:void(0)"
                                @click.prevent="showDetailsModal(orphan.orphan.id)"
                            >
                                <svg-loader class="me-2 h-4 w-4" name="icon-eye"></svg-loader>

                                {{ $t('show') }}
                            </a>

                            <a
                                class="flex items-center"
                                href="javascript:void(0)"
                                @click.prevent="showEditModal(orphan.orphan.id)"
                            >
                                <svg-loader class="me-2 h-4 w-4" name="icon-pen"></svg-loader>

                                {{ $t('edit') }}
                            </a>
                        </div>
                    </the-table-td-actions>
                </base-tr-table>
            </base-tbody-table>
        </base-table>

        <infos-show-modal :open="showDetailsModalStatus" @close="showDetailsModalStatus = false"></infos-show-modal>

        <infos-edit-modal
            :open="showEditModalStatus"
            :orphan-id="selectedOrphan"
            @close="closeEditModal"
        ></infos-edit-modal>
    </div>
</template>
