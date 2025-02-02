<script lang="ts" setup>
import { useSponsorshipsStore } from '@/stores/sponsorships'

import BaseFormInput from '@/Components/Base/form/BaseFormInput.vue'
import BaseFormLabel from '@/Components/Base/form/BaseFormLabel.vue'
import BaseFormSelect from '@/Components/Base/form/BaseFormSelect.vue'
import BaseInputGroup from '@/Components/Base/form/InputGroup/BaseInputGroup.vue'
import BaseFormSwitch from '@/Components/Base/form/form-switch/BaseFormSwitch.vue'
import BaseFormSwitchInput from '@/Components/Base/form/form-switch/BaseFormSwitchInput.vue'
import BaseFormSwitchLabel from '@/Components/Base/form/form-switch/BaseFormSwitchLabel.vue'
import PaginationDataTable from '@/Components/Global/PaginationDataTable.vue'
import SvgLoader from '@/Components/SvgLoader.vue'

import { allowOnlyNumbersOnKeyDown } from '@/utils/helper'
import { $t } from '@/utils/i18n'

const sponsorshipsStore = useSponsorshipsStore()

const removeMonthlyBasketItem = (id: string) => {
    sponsorshipsStore.monthly_basket.data.splice(id, 1)
}
</script>

<template>
    <div
        v-for="(item, index) in sponsorshipsStore.monthly_basket.data"
        :key="item.id"
        class="intro-y col-span-12 mt-4 grid grid-cols-12 gap-4"
    >
        <div class="col-span-12 sm:col-span-4">
            <base-form-label :for="`name-${index}`">
                {{ $t('item_name') }}
            </base-form-label>

            <base-form-input
                :id="`name-${index}`"
                v-model="item.name"
                :placeholder="
                    $t('auth.placeholders.tomselect', {
                        attribute: $t('item_name')
                    })
                "
                type="text"
            ></base-form-input>
        </div>

        <div class="col-span-12 sm:col-span-4">
            <base-form-label :for="`qty-${index}`">
                {{ $t('validation.attributes.qty_for_family') }}
            </base-form-label>

            <base-input-group>
                <base-form-input
                    :id="`qty-${index}`"
                    v-model="item.qty_for_family"
                    :placeholder="
                        $t('auth.placeholders.fill', {
                            attribute: $t('validation.attributes.qty')
                        })
                    "
                    maxlength="6"
                    type="text"
                    @keydown="allowOnlyNumbersOnKeyDown"
                ></base-form-input>

                <base-form-select v-model="item.unit" class="!w-28">
                    <option value="kg">{{ $t('kg') }}</option>
                    <option value="liter">{{ $t('liter') }}</option>
                    <option value="piece">{{ $t('piece') }}</option>
                </base-form-select>
            </base-input-group>
        </div>

        <div class="col-span-12 sm:col-span-3 lg:mt-6 lg:flex lg:items-center lg:justify-center">
            <base-form-switch class="text-lg">
                <base-form-switch-input
                    :id="`status-${index}`"
                    v-model="item.status"
                    type="checkbox"
                ></base-form-switch-input>

                <base-form-switch-label :htmlFor="`status-${index}`">
                    {{ $t('validation.attributes.the_status') }}
                </base-form-switch-label>
            </base-form-switch>
        </div>

        <div class="col-span-12 sm:col-span-1 lg:mt-6 lg:flex lg:items-center lg:justify-center">
            <span class="cursor-pointer" @click="removeMonthlyBasketItem(item.id)">
                <svg-loader class="fill-danger" name="icon-trash-can"></svg-loader>
            </span>
        </div>
    </div>

    <pagination-data-table
        :page="sponsorshipsStore.monthly_basket.meta.current_page"
        :pages="sponsorshipsStore.monthly_basket.meta.last_page"
        :per-page="sponsorshipsStore.monthly_basket.meta.per_page"
        class="mt-4"
        hide-per-page
        @change-page="sponsorshipsStore.getMonthlyBasketItems($event)"
    ></pagination-data-table>
</template>

<style lang="postcss" scoped></style>
