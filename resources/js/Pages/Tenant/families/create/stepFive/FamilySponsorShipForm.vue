<script lang="ts" setup>
import type { FamilySponsorship } from '@/types/types'

import { onMounted, ref } from 'vue'

import BaseFormTextArea from '@/Components/Base/form/BaseFormTextArea.vue'
import BaseFormSwitch from '@/Components/Base/form/form-switch/BaseFormSwitch.vue'
import BaseFormSwitchInput from '@/Components/Base/form/form-switch/BaseFormSwitchInput.vue'
import BaseFormSwitchLabel from '@/Components/Base/form/form-switch/BaseFormSwitchLabel.vue'

const items = ref<Record<FamilySponsorship, boolean>>({
    monthly_allowance: false,
    ramadan_basket: false,
    zakat: false,
    housing_assistance: false,
    eid_al_adha: false
})

const monthlyAllowance = defineModel('monthlyAllowance')

const ramadanBasket = defineModel('ramadanBasket')

const zakat = defineModel('zakat')

const housingAssistance = defineModel('housingAssistance')

const eidAlAdha = defineModel('eidAlAdha')

const valueMap = {
    monthly_allowance: monthlyAllowance,
    ramadan_basket: ramadanBasket,
    zakat: zakat,
    housing_assistance: housingAssistance,
    eid_al_adha: eidAlAdha
}

const toggle = (key: FamilySponsorship) => {
    items.value[key] = !items.value[key]

    if (items.value[key]) valueMap[key].value = true
    else valueMap[key].value = null
}

const setValue = (key: FamilySponsorship, event: Event) => {
    valueMap[key].value = (event.target as HTMLInputElement).value
}

onMounted(() => {
    if (zakat.value) items.value['zakat'] = true

    if (housingAssistance.value) items.value['housing_assistance'] = true

    if (eidAlAdha.value) items.value['eid_al_adha'] = true

    if (ramadanBasket.value) items.value['ramadan_basket'] = true

    if (monthlyAllowance.value) items.value['monthly_allowance'] = true
})
</script>

<template>
    <div class="mt-6 grid grid-cols-12 gap-4 gap-y-5">
        <!-- Begin: monthly Allowance -->
        <div class="intro-y col-span-12">
            <div class="grid grid-cols-12">
                <div class="col-span-12 lg:col-span-4">
                    <base-form-switch class="text-lg">
                        <base-form-switch-input
                            id="monthly_allowance"
                            :checked="items.monthly_allowance"
                            type="checkbox"
                            @change="toggle('monthly_allowance')"
                        ></base-form-switch-input>

                        <base-form-switch-label htmlFor="monthly_allowance">
                            {{ $t('sponsorships.monthly_allowance') }}
                        </base-form-switch-label>
                    </base-form-switch>
                </div>

                <div class="col-span-12 mt-3 lg:col-span-8 lg:mt-0">
                    <base-form-text-area
                        :disabled="!items.monthly_allowance"
                        :placeholder="$t('notes')"
                        :value="monthlyAllowance === true ? null : monthlyAllowance"
                        class="w-full md:w-3/4"
                        rows="4"
                        @input="setValue('monthly_allowance', $event)"
                    ></base-form-text-area>
                </div>
            </div>
        </div>
        <!-- End: monthly Allowance -->

        <!-- Begin: monthly Allowance -->
        <div class="intro-y col-span-12">
            <div class="grid grid-cols-12">
                <div class="col-span-12 lg:col-span-4">
                    <base-form-switch class="text-lg">
                        <base-form-switch-input
                            id="ramadan_basket"
                            :checked="items.ramadan_basket"
                            type="checkbox"
                            @change="toggle('ramadan_basket')"
                        ></base-form-switch-input>

                        <base-form-switch-label htmlFor="ramadan_basket">
                            {{ $t('sponsorships.ramadan_basket') }}
                        </base-form-switch-label>
                    </base-form-switch>
                </div>

                <div class="col-span-12 mt-3 lg:col-span-8 lg:mt-0">
                    <base-form-text-area
                        :disabled="!items.ramadan_basket"
                        :placeholder="$t('notes')"
                        :value="ramadanBasket === true ? null : ramadanBasket"
                        class="w-full md:w-3/4"
                        rows="4"
                        @input="setValue('ramadan_basket', $event)"
                    ></base-form-text-area>
                </div>
            </div>
        </div>
        <!-- End: monthly Allowance -->

        <!-- Begin: monthly Allowance -->
        <div class="intro-y col-span-12">
            <div class="grid grid-cols-12">
                <div class="col-span-12 lg:col-span-4">
                    <base-form-switch class="text-lg">
                        <base-form-switch-input
                            id="zakat"
                            :checked="items.zakat"
                            type="checkbox"
                            @change="toggle('zakat')"
                        ></base-form-switch-input>

                        <base-form-switch-label htmlFor="zakat">
                            {{ $t('sponsorships.zakat') }}
                        </base-form-switch-label>
                    </base-form-switch>
                </div>

                <div class="col-span-12 mt-3 lg:col-span-8 lg:mt-0">
                    <base-form-text-area
                        :disabled="!items.zakat"
                        :placeholder="$t('notes')"
                        :value="zakat === true ? null : zakat"
                        class="w-full md:w-3/4"
                        rows="4"
                        @input="setValue('zakat', $event)"
                    ></base-form-text-area>
                </div>
            </div>
        </div>
        <!-- End: monthly Allowance -->

        <!-- Begin: monthly Allowance -->
        <div class="intro-y col-span-12">
            <div class="grid grid-cols-12">
                <div class="col-span-12 lg:col-span-4">
                    <base-form-switch class="text-lg">
                        <base-form-switch-input
                            id="housing_assistance"
                            :checked="items.housing_assistance"
                            type="checkbox"
                            @change="toggle('housing_assistance')"
                        ></base-form-switch-input>

                        <base-form-switch-label htmlFor="housing_assistance">
                            {{ $t('sponsorships.housing_assistance') }}
                        </base-form-switch-label>
                    </base-form-switch>
                </div>

                <div class="col-span-12 mt-3 lg:col-span-8 lg:mt-0">
                    <base-form-text-area
                        :disabled="!items.housing_assistance"
                        :placeholder="$t('notes')"
                        :value="housingAssistance === true ? null : housingAssistance"
                        class="w-full md:w-3/4"
                        rows="4"
                        @input="setValue('housing_assistance', $event)"
                    ></base-form-text-area>
                </div>
            </div>
        </div>
        <!-- End: monthly Allowance -->

        <!-- Begin: monthly Allowance -->
        <div class="intro-y col-span-12">
            <div class="grid grid-cols-12">
                <div class="col-span-12 lg:col-span-4">
                    <base-form-switch class="text-lg">
                        <base-form-switch-input
                            id="eid_al_adha"
                            :checked="items.eid_al_adha"
                            type="checkbox"
                            @change="toggle('eid_al_adha')"
                        ></base-form-switch-input>

                        <base-form-switch-label htmlFor="eid_al_adha">
                            {{ $t('sponsorships.eid_al_adha') }}
                        </base-form-switch-label>
                    </base-form-switch>
                </div>

                <div class="col-span-12 mt-3 lg:col-span-8 lg:mt-0">
                    <base-form-text-area
                        :disabled="!items.eid_al_adha"
                        :placeholder="$t('notes')"
                        :value="eidAlAdha === true ? null : eidAlAdha"
                        class="w-full md:w-3/4"
                        rows="4"
                        @input="setValue('eid_al_adha', $event)"
                    ></base-form-text-area>
                </div>
            </div>
        </div>
        <!-- End: monthly Allowance -->
    </div>
</template>
