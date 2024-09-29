<script lang="ts" setup>
import type { FurnishingsType } from '@/types/types'

import { type ModelRef, onMounted, ref } from 'vue'

import BaseFormTextArea from '@/Components/Base/form/BaseFormTextArea.vue'
import BaseFormSwitch from '@/Components/Base/form/form-switch/BaseFormSwitch.vue'
import BaseFormSwitchInput from '@/Components/Base/form/form-switch/BaseFormSwitchInput.vue'
import BaseFormSwitchLabel from '@/Components/Base/form/form-switch/BaseFormSwitchLabel.vue'

const emit = defineEmits(['update:furnishings'])

const items = ref<Record<FurnishingsType, boolean>>({
    television: false,
    refrigerator: false,
    fireplace: false,
    washing_machine: false,
    water_heater: false,
    oven: false,
    wardrobe: false,
    cupboard: false,
    covers: false,
    mattresses: false,
    other_furnishings: false
})

const television = defineModel('television')

const refrigerator = defineModel('refrigerator')

const fireplace = defineModel('fireplace')

const washingMachine = defineModel('washingMachine')

const waterHeater = defineModel('waterHeater')

const oven = defineModel('oven')

const wardrobe = defineModel('wardrobe')

const cupboard = defineModel('cupboard')

const covers = defineModel('covers')

const mattresses = defineModel('mattresses')

const valueMap: Record<FurnishingsType, ModelRef<unknown>> = {
    television: television,
    refrigerator: refrigerator,
    fireplace: fireplace,
    washing_machine: washingMachine,
    water_heater: waterHeater,
    oven: oven,
    wardrobe: wardrobe,
    cupboard: cupboard,
    covers: covers,
    mattresses: mattresses,
    other_furnishings: mattresses
}

const toggle = (key: FurnishingsType) => {
    items.value[key] = !items.value[key]

    if (!items.value[key]) valueMap[key].value = null

    emit('update:furnishings', items.value)
}

onMounted(() => {
    const keys = [
        'television',
        'refrigerator',
        'fireplace',
        'washingMachine',
        'washing_machine',
        'waterHeater',
        'water_heater',
        'oven',
        'wardrobe',
        'cupboard',
        'covers',
        'mattresses'
    ]

    for (const key of keys) {
        if (eval(key + '.value')) {
            // @ts-ignore
            items.value[key] = true
        }
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
                            :checked="items.television"
                            type="checkbox"
                            @change="toggle('television')"
                        ></base-form-switch-input>

                        <base-form-switch-label htmlFor="television">
                            {{ $t('furnishings.television') }}
                        </base-form-switch-label>
                    </base-form-switch>
                </div>
                <div class="col-span-12 mt-2 lg:col-span-8 lg:mt-0">
                    <base-form-text-area
                        v-model="television"
                        :disabled="!items.television"
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
                            :checked="items.refrigerator"
                            type="checkbox"
                            @change="toggle('refrigerator')"
                        ></base-form-switch-input>

                        <base-form-switch-label htmlFor="refrigerator">
                            {{ $t('furnishings.refrigerator') }}
                        </base-form-switch-label>
                    </base-form-switch>
                </div>
                <div class="col-span-12 mt-2 lg:col-span-8 lg:mt-0">
                    <base-form-text-area
                        v-model="refrigerator"
                        :disabled="!items.refrigerator"
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
                            :checked="items.fireplace"
                            type="checkbox"
                            @change="toggle('fireplace')"
                        ></base-form-switch-input>

                        <base-form-switch-label htmlFor="fireplace">
                            {{ $t('furnishings.fireplace') }}
                        </base-form-switch-label>
                    </base-form-switch>
                </div>
                <div class="col-span-12 mt-2 lg:col-span-8 lg:mt-0">
                    <base-form-text-area
                        v-model="fireplace"
                        :disabled="!items.fireplace"
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
                            :checked="items.washing_machine"
                            type="checkbox"
                            @change="toggle('washing_machine')"
                        ></base-form-switch-input>

                        <base-form-switch-label htmlFor="washing_machine">
                            {{ $t('furnishings.washing_machine') }}
                        </base-form-switch-label>
                    </base-form-switch>
                </div>
                <div class="col-span-12 mt-2 lg:col-span-8 lg:mt-0">
                    <base-form-text-area
                        v-model="washingMachine"
                        :disabled="!items.washing_machine"
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
                            :checked="items.water_heater"
                            type="checkbox"
                            @change="toggle('water_heater')"
                        ></base-form-switch-input>

                        <base-form-switch-label htmlFor="water_heater">
                            {{ $t('furnishings.water_heater') }}
                        </base-form-switch-label>
                    </base-form-switch>
                </div>
                <div class="col-span-12 mt-2 lg:col-span-8 lg:mt-0">
                    <base-form-text-area
                        v-model="waterHeater"
                        :disabled="!items.water_heater"
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
                            :checked="items.oven"
                            type="checkbox"
                            @change="toggle('oven')"
                        ></base-form-switch-input>

                        <base-form-switch-label htmlFor="oven">
                            {{ $t('furnishings.oven') }}
                        </base-form-switch-label>
                    </base-form-switch>
                </div>
                <div class="col-span-12 mt-2 lg:col-span-8 lg:mt-0">
                    <base-form-text-area
                        v-model="oven"
                        :disabled="!items.oven"
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
                            :checked="items.wardrobe"
                            type="checkbox"
                            @change="toggle('wardrobe')"
                        ></base-form-switch-input>

                        <base-form-switch-label htmlFor="wardrobe">
                            {{ $t('furnishings.wardrobe') }}
                        </base-form-switch-label>
                    </base-form-switch>
                </div>
                <div class="col-span-12 mt-2 lg:col-span-8 lg:mt-0">
                    <base-form-text-area
                        v-model="wardrobe"
                        :disabled="!items.wardrobe"
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
                            :checked="items.cupboard"
                            type="checkbox"
                            @change="toggle('cupboard')"
                        ></base-form-switch-input>

                        <base-form-switch-label htmlFor="cupboard">
                            {{ $t('furnishings.cupboard') }}
                        </base-form-switch-label>
                    </base-form-switch>
                </div>
                <div class="col-span-12 mt-2 lg:col-span-8 lg:mt-0">
                    <base-form-text-area
                        v-model="cupboard"
                        :disabled="!items.cupboard"
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
                            :checked="items.covers"
                            type="checkbox"
                            @change="toggle('covers')"
                        ></base-form-switch-input>

                        <base-form-switch-label htmlFor="covers">
                            {{ $t('furnishings.covers') }}
                        </base-form-switch-label>
                    </base-form-switch>
                </div>
                <div class="col-span-12 mt-2 lg:col-span-8 lg:mt-0">
                    <base-form-text-area
                        v-model="covers"
                        :disabled="!items.covers"
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
                            :checked="items.mattresses"
                            type="checkbox"
                            @change="toggle('mattresses')"
                        ></base-form-switch-input>

                        <base-form-switch-label htmlFor="mattresses">
                            {{ $t('furnishings.mattresses') }}
                        </base-form-switch-label>
                    </base-form-switch>
                </div>
                <div class="col-span-12 mt-2 lg:col-span-8 lg:mt-0">
                    <base-form-text-area
                        v-model="mattresses"
                        :disabled="!items.mattresses"
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
