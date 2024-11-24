<script lang="ts" setup>
import type { EidSuitOrphansResource, IndexParams, PaginationData } from '@/types/types'

import { Link } from '@inertiajs/vue3'
import { useForm } from 'laravel-precognition-vue'
import { nextTick, ref } from 'vue'

import BaseFormInput from '@/Components/Base/form/BaseFormInput.vue'
import BaseTable from '@/Components/Base/table/BaseTable.vue'
import BaseTbodyTable from '@/Components/Base/table/BaseTbodyTable.vue'
import BaseTheadTable from '@/Components/Base/table/BaseTheadTable.vue'
import BaseTrTable from '@/Components/Base/table/BaseTrTable.vue'
import BaseTippy from '@/Components/Base/tippy/BaseTippy.vue'
import TheTableTd from '@/Components/Global/DataTable/TheTableTd.vue'
import TheTableTh from '@/Components/Global/DataTable/TheTableTh.vue'
import MembersFilterDropDown from '@/Components/Global/filters/MembersFilterDropDown.vue'
import SvgLoader from '@/Components/SvgLoader.vue'

import { debounce, formatCurrency } from '@/utils/helper'
import { $t, $tc } from '@/utils/i18n'

defineProps<{ orphans: PaginationData<EidSuitOrphansResource>; params: IndexParams }>()

const emit = defineEmits(['sort'])

const selectedOrphan = ref({
    orphan_id: '',
    clothes_shop_name: '',
    clothes_shop_phone_number: '',
    designated_member: '',
    shoes_shop_name: '',
    shoes_shop_phone_number: '',
    note: ''
})

const handleInputBlur = (orphan: EidSuitOrphansResource, field: string, event: Event) => {
    if (event?.target.value) {
        if (selectedOrphan.value.orphan_id !== orphan.id) {
            selectedOrphan.value = {}
        }

        selectedOrphan.value.orphan_id = orphan.id

        selectedOrphan.value[field] = (event.target as HTMLInputElement).value

        orphan.orphan.edit = false
    }
}

const form = useForm('get', route('tenant.orphans.edit', selectedOrphan.value.orphan_id), {
    ...selectedOrphan.value
})

const submit = debounce(() => {
    alert('11')
}, 2000)

const handleSelectDesignatedMember = (orphan_id: string, event: { id: string; name: string }) => {
    if (event.id) {
        selectedOrphan.value.orphan_id = orphan_id

        selectedOrphan.value.designated_member = event
    }

    submit()
}

const handleclick = (orphan: EidSuitOrphansResource, field: string) => {
    orphan.orphan.edit = true

    nextTick(() => {
        const a = document.getElementById(`clothes_shop_phone_number_${orphan.id}`)

        a?.focus()

        a.value = orphan.eid_suit[field]
    })
}
</script>

<template>
    <div class="@container">
        <div class="intro-y !z-30 col-span-12 hidden overflow-x-scroll @3xl:block">
            <base-table class="mt-2 border-separate border-spacing-y-[10px]">
                <base-thead-table>
                    <base-tr-table>
                        <the-table-th class="text-start"> #</the-table-th>

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
                            :direction="params.directions && params.directions['age']"
                            class="text-center"
                            sortable
                            @click="emit('sort', 'age')"
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

                        <the-table-th>{{ $t('clothes_shop_name') }}</the-table-th>

                        <the-table-th>{{ $t('clothes_shop_phone_number') }}</the-table-th>

                        <the-table-th>{{ $t('shoes_shop_name') }}</the-table-th>

                        <the-table-th>{{ $t('shoes_shop_phone_number') }}</the-table-th>

                        <the-table-th>{{ $t('designated_member') }}</the-table-th>

                        <the-table-th>{{ $t('validation.attributes.note') }}</the-table-th>

                        <the-table-th>{{ $t('location') }}</the-table-th>

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

                        <the-table-th class="text-start">{{ $t('validation.attributes.address') }}</the-table-th>
                    </base-tr-table>
                </base-thead-table>

                <base-tbody-table>
                    <base-tr-table v-for="(orphan, index) in orphans.data" :key="orphan.id" class="intro-x">
                        <the-table-td class="w-16">
                            {{ (orphans.meta.from ?? 0) + index }}
                        </the-table-td>

                        <the-table-td class="!min-w-24 !max-w-24 truncate">
                            <Link :href="route('tenant.orphans.show', orphan.orphan.id)" class="font-medium">
                                {{ orphan.orphan.name }}
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

                        <the-table-td>
                            <base-form-input
                                :value="selectedOrphan.orphan_id === orphan.id ? selectedOrphan.clothes_shop_name : ''"
                                @blur.prevent="handleInputBlur(orphan, 'clothes_shop_name', $event)"
                            ></base-form-input>
                        </the-table-td>

                        <the-table-td>
                            <span
                                v-if="!orphan.orphan.edit"
                                class="cursor-pointer"
                                @click="handleclick(orphan, 'clothes_shop_phone_number')"
                                >t nameest</span
                            >
                            <base-form-input
                                v-else
                                :id="`clothes_shop_phone_number_${orphan.id}`"
                                maxlength="10"
                                minlength="10"
                                @blur.prevent="handleInputBlur(orphan, 'clothes_shop_phone_number', $event)"
                            ></base-form-input>
                        </the-table-td>

                        <the-table-td>
                            <base-form-input
                                @blur.prevent="handleInputBlur(orphan.id, 'shoes_shop_name', $event)"
                            ></base-form-input>
                        </the-table-td>

                        <the-table-td>
                            <base-form-input
                                @blur.prevent="handleInputBlur(orphan.id, 'shoes_shop_phone_number', $event)"
                            ></base-form-input>
                        </the-table-td>

                        <the-table-td>
                            <members-filter-drop-down
                                :value="selectedOrphan.orphan_id === orphan.id ? selectedOrphan.designated_member : ''"
                                class="!w-40"
                                @update:value="handleSelectDesignatedMember(orphan.id, $event)"
                            ></members-filter-drop-down>
                        </the-table-td>

                        <the-table-td>
                            <base-form-input
                                @blur.prevent="handleInputBlur(orphan.id, 'note', $event)"
                            ></base-form-input>
                        </the-table-td>

                        <the-table-td>
                            <svg-loader class="h-5 w-5" name="icon-map-location-dot"></svg-loader>
                        </the-table-td>

                        <the-table-td class="!min-w-24 !max-w-24 truncate">
                            <Link :href="route('tenant.sponsors.show', orphan.sponsor.id)" class="font-medium">
                                {{ orphan.sponsor.name }}
                            </Link>
                        </the-table-td>

                        <the-table-td class="whitespace-nowrap text-center">
                            {{ orphan.sponsor.phone_number }}
                        </the-table-td>

                        <the-table-td class="max-w-40 truncate">
                            {{ orphan.family.address }}

                            <Link
                                :href="route('tenant.zones.index') + `?show=${orphan.family.zone?.id}`"
                                class="mt-0.5 block whitespace-nowrap text-xs text-slate-500"
                            >
                                {{ orphan.family.zone?.name }}
                            </Link>
                        </the-table-td>
                    </base-tr-table>
                </base-tbody-table>
            </base-table>
        </div>

        <div class="col-span-12 my-8 grid grid-cols-12 gap-4 @3xl:hidden">
            <div v-for="orphan in orphans.data" :key="orphan.id" class="intro-y !z-10 col-span-12 @xl:col-span-6">
                <div class="box p-5">
                    <div class="flex">
                        <div class="me-3 truncate text-lg font-medium">
                            <Link :href="route('tenant.orphans.show', orphan.orphan.id)" class="font-medium">
                                {{ orphan.orphan.name }}
                            </Link>
                        </div>
                        <div
                            class="ms-auto flex cursor-pointer items-center truncate rounded-full bg-slate-100 px-2 py-1 text-xs text-slate-500 dark:bg-darkmode-400"
                        >
                            <span v-if="orphan.orphan.age > 0">{{
                                $tc('age_years', orphan.orphan.age, { count: String(orphan.orphan.age) })
                            }}</span>

                            <span v-else> {{ $t('low_than_one_year') }}</span>
                        </div>
                    </div>
                    <div class="mt-6 grid grid-cols-12 gap-2">
                        <p class="col-span-12 text-base">
                            <Link
                                v-if="orphan.sponsor.id"
                                :href="route('tenant.sponsors.show', orphan.sponsor.id)"
                                class="font-medium rtl:font-semibold"
                            >
                                {{ orphan.sponsor?.name }}
                            </Link>
                        </p>

                        <div class="col-span-12 mt-2 grid grid-cols-12 gap-2">
                            <div class="col-span-12 grid grid-cols-12 gap-2">
                                <p class="col-span-4 rtl:font-semibold">{{ $t('shoes_size') }}</p>

                                <p class="col-span-8">
                                    {{ orphan.orphan.shoes_size }}
                                </p>
                            </div>

                            <div class="col-span-12 grid grid-cols-12 gap-2">
                                <p class="col-span-4 rtl:font-semibold">{{ $t('shirt_size') }}</p>

                                <p class="col-span-8">
                                    {{ orphan.orphan.shirt_size }}
                                </p>
                            </div>

                            <div class="col-span-12 grid grid-cols-12 gap-2">
                                <p class="col-span-4 rtl:font-semibold">{{ $t('pants_size') }}</p>

                                <p class="col-span-8">
                                    {{ orphan.orphan.pants_size }}
                                </p>
                            </div>

                            <div class="col-span-12">
                                <base-form-input></base-form-input>
                            </div>
                        </div>
                        <div
                            class="mt-2 flex h-fit w-fit items-center truncate rounded-full bg-slate-100 px-2 py-1 text-xs font-semibold text-slate-400/80 dark:bg-darkmode-400"
                        >
                            <base-tippy :content="$t('sponsor_phone_number')">
                                {{ orphan.sponsor?.phone_number }}
                            </base-tippy>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
