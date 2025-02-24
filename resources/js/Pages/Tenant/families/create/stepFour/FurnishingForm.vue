<script lang="ts" setup>
import { useCreateFamilyStore } from '@/stores/create-family'
import { usePage } from '@inertiajs/vue3'
import { onMounted } from 'vue'

import BaseFormTextArea from '@/Components/Base/form/BaseFormTextArea.vue'
import BaseFormSwitch from '@/Components/Base/form/form-switch/BaseFormSwitch.vue'
import BaseFormSwitchInput from '@/Components/Base/form/form-switch/BaseFormSwitchInput.vue'
import BaseFormSwitchLabel from '@/Components/Base/form/form-switch/BaseFormSwitchLabel.vue'

const createFamilyStore = useCreateFamilyStore()

onMounted(() => {
    if (usePage().component !== 'Tenant/families/edit/FamilyEditPage') {
        document.getElementById('television')?.focus()
    }
})
</script>

<template>
    <div class="mt-6 grid grid-cols-12 gap-4 gap-y-5">
        <!-- Begin: Television -->
        <div class="intro-y col-span-12">
            <div class="grid grid-cols-12">
                <div class="col-span-12 lg:col-span-4">
                    <base-form-switch class="text-lg">
                        <base-form-switch-input
                            id="television"
                            v-model="createFamilyStore.family.furnishings.television.checked"
                            type="checkbox"
                        ></base-form-switch-input>

                        <base-form-switch-label htmlFor="television">
                            {{ $t('furnishings.television') }}
                        </base-form-switch-label>
                    </base-form-switch>
                </div>
                <div class="col-span-12 mt-2 lg:col-span-8 lg:mt-0">
                    <base-form-text-area
                        v-model="createFamilyStore.family.furnishings.television.note"
                        :placeholder="$t('notes')"
                        class="w-full md:w-3/4"
                        rows="4"
                    ></base-form-text-area>
                </div>
            </div>
        </div>
        <!-- End: Television -->

        <!-- Begin: Refrigerator -->
        <div class="intro-y col-span-12">
            <div class="grid grid-cols-12">
                <div class="col-span-12 lg:col-span-4">
                    <base-form-switch class="text-lg">
                        <base-form-switch-input
                            id="refrigerator"
                            v-model="createFamilyStore.family.furnishings.refrigerator.checked"
                            type="checkbox"
                        ></base-form-switch-input>

                        <base-form-switch-label htmlFor="refrigerator">
                            {{ $t('furnishings.refrigerator') }}
                        </base-form-switch-label>
                    </base-form-switch>
                </div>
                <div class="col-span-12 mt-2 lg:col-span-8 lg:mt-0">
                    <base-form-text-area
                        v-model="createFamilyStore.family.furnishings.refrigerator.note"
                        :placeholder="$t('notes')"
                        class="w-full md:w-3/4"
                        rows="4"
                    ></base-form-text-area>
                </div>
            </div>
        </div>
        <!-- End: Refrigerator -->

        <!-- Begin: Fireplace -->
        <div class="intro-y col-span-12">
            <div class="grid grid-cols-12">
                <div class="col-span-12 lg:col-span-4">
                    <base-form-switch class="text-lg">
                        <base-form-switch-input
                            id="fireplace"
                            v-model="createFamilyStore.family.furnishings.fireplace.checked"
                            type="checkbox"
                        ></base-form-switch-input>

                        <base-form-switch-label htmlFor="fireplace">
                            {{ $t('furnishings.fireplace') }}
                        </base-form-switch-label>
                    </base-form-switch>
                </div>
                <div class="col-span-12 mt-2 lg:col-span-8 lg:mt-0">
                    <base-form-text-area
                        v-model="createFamilyStore.family.furnishings.fireplace.note"
                        :placeholder="$t('notes')"
                        class="w-full md:w-3/4"
                        rows="4"
                    ></base-form-text-area>
                </div>
            </div>
        </div>
        <!-- End: Fireplace -->

        <!-- Begin: washing Machine -->
        <div class="intro-y col-span-12">
            <div class="grid grid-cols-12">
                <div class="col-span-12 lg:col-span-4">
                    <base-form-switch class="text-lg">
                        <base-form-switch-input
                            id="washing_machine"
                            v-model="createFamilyStore.family.furnishings.washing_machine.checked"
                            type="checkbox"
                        ></base-form-switch-input>

                        <base-form-switch-label htmlFor="washing_machine">
                            {{ $t('furnishings.washing_machine') }}
                        </base-form-switch-label>
                    </base-form-switch>
                </div>
                <div class="col-span-12 mt-2 lg:col-span-8 lg:mt-0">
                    <base-form-text-area
                        v-model="createFamilyStore.family.furnishings.washing_machine.note"
                        :placeholder="$t('notes')"
                        class="w-full md:w-3/4"
                        rows="4"
                    ></base-form-text-area>
                </div>
            </div>
        </div>
        <!-- End: washing Machine -->

        <!-- Begin: Water Heater -->
        <div class="intro-y col-span-12">
            <div class="grid grid-cols-12">
                <div class="col-span-12 lg:col-span-4">
                    <base-form-switch class="text-lg">
                        <base-form-switch-input
                            id="water_heater"
                            v-model="createFamilyStore.family.furnishings.water_heater.checked"
                            type="checkbox"
                        ></base-form-switch-input>

                        <base-form-switch-label htmlFor="water_heater">
                            {{ $t('furnishings.water_heater') }}
                        </base-form-switch-label>
                    </base-form-switch>
                </div>
                <div class="col-span-12 mt-2 lg:col-span-8 lg:mt-0">
                    <base-form-text-area
                        v-model="createFamilyStore.family.furnishings.water_heater.note"
                        :placeholder="$t('notes')"
                        class="w-full md:w-3/4"
                        rows="4"
                    ></base-form-text-area>
                </div>
            </div>
        </div>
        <!-- End: Water Heater -->

        <!-- Begin: Oven -->
        <div class="intro-y col-span-12">
            <div class="grid grid-cols-12">
                <div class="col-span-12 lg:col-span-4">
                    <base-form-switch class="text-lg">
                        <base-form-switch-input
                            id="oven"
                            v-model="createFamilyStore.family.furnishings.oven.checked"
                            type="checkbox"
                        ></base-form-switch-input>

                        <base-form-switch-label htmlFor="oven">
                            {{ $t('furnishings.oven') }}
                        </base-form-switch-label>
                    </base-form-switch>
                </div>
                <div class="col-span-12 mt-2 lg:col-span-8 lg:mt-0">
                    <base-form-text-area
                        v-model="createFamilyStore.family.furnishings.oven.note"
                        :placeholder="$t('notes')"
                        class="w-full md:w-3/4"
                        rows="4"
                    ></base-form-text-area>
                </div>
            </div>
        </div>
        <!-- End: Oven -->

        <!-- Begin: Wardrobe -->
        <div class="intro-y col-span-12">
            <div class="grid grid-cols-12">
                <div class="col-span-12 lg:col-span-4">
                    <base-form-switch class="text-lg">
                        <base-form-switch-input
                            id="wardrobe"
                            v-model="createFamilyStore.family.furnishings.wardrobe.checked"
                            type="checkbox"
                        ></base-form-switch-input>

                        <base-form-switch-label htmlFor="wardrobe">
                            {{ $t('furnishings.wardrobe') }}
                        </base-form-switch-label>
                    </base-form-switch>
                </div>
                <div class="col-span-12 mt-2 lg:col-span-8 lg:mt-0">
                    <base-form-text-area
                        v-model="createFamilyStore.family.furnishings.wardrobe.note"
                        :placeholder="$t('notes')"
                        class="w-full md:w-3/4"
                        rows="4"
                    ></base-form-text-area>
                </div>
            </div>
        </div>
        <!-- End: Wardrobe -->

        <!-- Begin: Cupboard -->
        <div class="intro-y col-span-12">
            <div class="grid grid-cols-12">
                <div class="col-span-12 lg:col-span-4">
                    <base-form-switch class="text-lg">
                        <base-form-switch-input
                            id="cupboard"
                            v-model="createFamilyStore.family.furnishings.cupboard.checked"
                            type="checkbox"
                        ></base-form-switch-input>

                        <base-form-switch-label htmlFor="cupboard">
                            {{ $t('furnishings.cupboard') }}
                        </base-form-switch-label>
                    </base-form-switch>
                </div>
                <div class="col-span-12 mt-2 lg:col-span-8 lg:mt-0">
                    <base-form-text-area
                        v-model="createFamilyStore.family.furnishings.cupboard.note"
                        :placeholder="$t('notes')"
                        class="w-full md:w-3/4"
                        rows="4"
                    ></base-form-text-area>
                </div>
            </div>
        </div>
        <!-- End: Cupboard -->

        <!-- Begin: Covers -->
        <div class="intro-y col-span-12">
            <div class="grid grid-cols-12">
                <div class="col-span-12 lg:col-span-4">
                    <base-form-switch class="text-lg">
                        <base-form-switch-input
                            id="covers"
                            v-model="createFamilyStore.family.furnishings.covers.checked"
                            type="checkbox"
                        ></base-form-switch-input>

                        <base-form-switch-label htmlFor="covers">
                            {{ $t('furnishings.covers') }}
                        </base-form-switch-label>
                    </base-form-switch>
                </div>
                <div class="col-span-12 mt-2 lg:col-span-8 lg:mt-0">
                    <base-form-text-area
                        v-model="createFamilyStore.family.furnishings.covers.note"
                        :placeholder="$t('notes')"
                        class="w-full md:w-3/4"
                        rows="4"
                    ></base-form-text-area>
                </div>
            </div>
        </div>
        <!-- End: Covers -->

        <!-- Begin: Mattresses -->
        <div class="intro-y col-span-12">
            <div class="grid grid-cols-12">
                <div class="col-span-12 lg:col-span-4">
                    <base-form-switch class="text-lg">
                        <base-form-switch-input
                            id="mattresses"
                            v-model="createFamilyStore.family.furnishings.mattresses.checked"
                            type="checkbox"
                        ></base-form-switch-input>

                        <base-form-switch-label htmlFor="mattresses">
                            {{ $t('furnishings.mattresses') }}
                        </base-form-switch-label>
                    </base-form-switch>
                </div>
                <div class="col-span-12 mt-2 lg:col-span-8 lg:mt-0">
                    <base-form-text-area
                        v-model="createFamilyStore.family.furnishings.mattresses.note"
                        :placeholder="$t('notes')"
                        class="w-full md:w-3/4"
                        rows="4"
                    ></base-form-text-area>
                </div>
            </div>
        </div>
        <!-- End: Mattresses -->
    </div>
</template>
