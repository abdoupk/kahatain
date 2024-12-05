<script lang="ts" setup>
import { CreateSponsorshipForm } from '@/types/types'

import type { Form } from 'laravel-precognition-vue/dist/types'

import BaseFormInput from '@/Components/Base/form/BaseFormInput.vue'
import BaseFormLabel from '@/Components/Base/form/BaseFormLabel.vue'
import BaseInputError from '@/Components/Base/form/BaseInputError.vue'
import BaseInputGroup from '@/Components/Base/form/InputGroup/BaseInputGroup.vue'
import BaseInputGroupText from '@/Components/Base/form/InputGroup/BaseInputGroupText.vue'
import SvgLoader from '@/Components/SvgLoader.vue'

import { $t } from '@/utils/i18n'

defineProps<{
    form: Form<CreateSponsorshipForm>
    index: number
}>()

const emit = defineEmits(['removeInterval'])

const minimum = defineModel('minimum')

const maximum = defineModel('maximum')

const value = defineModel('value')
</script>

<template>
    <div class="col-span-12 grid grid-cols-12 gap-4">
        <!-- Begin: Minimum-->
        <div class="col-span-12 sm:col-span-4">
            <base-form-label htmlFor="minimum">
                {{ $t('validation.attributes.minimum') }}
            </base-form-label>

            <base-input-group>
                <base-form-input
                    id="minimum"
                    v-model="minimum"
                    type="number"
                    :placeholder="$t('auth.placeholders.fill', { attribute: $t('validation.attributes.minimum') })"
                    @change="form.validate(`categories.${index}.minimum`)"
                ></base-form-input>

                <base-input-group-text>
                    {{ $t('DA') }}
                </base-input-group-text>
            </base-input-group>

            <!-- @vue-ignore -->
            <div v-if="form.invalid(`categories.${index}.minimum`)" class="mt-2">
                <!-- @vue-ignore -->
                <base-input-error :message="form.errors[`categories.${index}.minimum`]"></base-input-error>
            </div>
        </div>
        <!-- End: Minimum-->

        <!-- Begin: Maximum-->
        <div class="col-span-12 sm:col-span-4">
            <base-form-label htmlFor="maximum">
                {{ $t('validation.attributes.maximum') }}
            </base-form-label>

            <base-input-group>
                <base-form-input
                    id="maximum"
                    v-model="maximum"
                    type="number"
                    :placeholder="$t('auth.placeholders.fill', { attribute: $t('validation.attributes.maximum') })"
                    @change="form.validate(`categories.${index}.maximum`)"
                ></base-form-input>

                <base-input-group-text>
                    {{ $t('DA') }}
                </base-input-group-text>
            </base-input-group>

            <!-- @vue-ignore -->
            <div v-if="form.invalid(`categories.${index}.maximum`)" class="mt-2">
                <!-- @vue-ignore -->
                <base-input-error :message="form.errors[`categories.${index}.maximum`]"></base-input-error>
            </div>
        </div>
        <!-- End: Maximum-->

        <!-- Begin: Value-->
        <div class="col-span-12 sm:col-span-4">
            <base-form-label htmlFor="value">
                {{ $t('the_percentage') }}
            </base-form-label>

            <div class="flex">
                <base-input-group class="grow">
                    <base-form-input
                        id="value"
                        v-model="value"
                        type="number"
                        :placeholder="$t('auth.placeholders.fill', { attribute: $t('the_percentage') })"
                        @change="form.validate(`categories.${index}.value`)"
                    ></base-form-input>

                    <base-input-group-text> % </base-input-group-text>
                </base-input-group>

                <svg-loader
                    :class="{ '!cursor-not-allowed': index === 0 }"
                    class="me-1 ms-2 mt-2 h-5 w-5 cursor-pointer fill-danger"
                    name="icon-trash-can"
                    @click.prevent="emit('removeInterval', index)"
                ></svg-loader>
            </div>

            <!-- @vue-ignore -->
            <div v-if="form.invalid(`categories.${index}.value`)" class="mt-2">
                <!-- @vue-ignore -->
                <base-input-error :message="form.errors[`categories.${index}.value`]"></base-input-error>
            </div>
        </div>
        <!-- End: Value-->
    </div>
</template>
