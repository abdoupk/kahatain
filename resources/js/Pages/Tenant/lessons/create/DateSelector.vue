<script lang="ts" setup>
import type { CreateLessonForm } from '@/types/types'

import type { Form } from 'laravel-precognition-vue/dist/types'
import { onMounted, ref, watch } from 'vue'

import BaseVCalendar from '@/Components/Base/VCalendar/BaseVCalendar.vue'
import BaseFormInput from '@/Components/Base/form/BaseFormInput.vue'
import BaseFormInputError from '@/Components/Base/form/BaseFormInputError.vue'
import BaseFormLabel from '@/Components/Base/form/BaseFormLabel.vue'
import BaseFormSelect from '@/Components/Base/form/BaseFormSelect.vue'
import BaseInputError from '@/Components/Base/form/BaseInputError.vue'

import { setDateToCurrentTime } from '@/utils/helper'

const props = defineProps<{
    form: Form<CreateLessonForm>
    date: string | Date
}>()

const interval = defineModel('interval')

const disabled = defineModel('disabled')

const frequency = defineModel('frequency')

const startDate = defineModel<string | Date>('startDate')

const until = defineModel('until')

const endDate = defineModel<string | Date>('endDate')

const date = ref(props.date)

const setTimes = (value: string | Date) => {
    const formattedDate = setDateToCurrentTime(value)

    startDate.value = formattedDate.toDate()

    endDate.value = formattedDate.add(1, 'hour').toDate()

    return formattedDate
}

watch(
    () => date.value,
    (value) => {
        setTimes(value)
    }
)

onMounted(() => {
    if (!startDate.value) {
        date.value = setTimes(date.value).toDate()
    }
})
</script>

<template>
    <!-- Begin: Date Range-->
    <div class="col-span-12 grid grid-cols-12 gap-4">
        <div class="col-span-12 sm:col-span-4">
            <base-form-label for="date">
                {{ $t('validation.attributes.date') }}
            </base-form-label>

            <base-v-calendar v-model:date="date" mode="date"></base-v-calendar>
        </div>

        <div class="col-span-12 sm:col-span-4">
            <base-form-label for="start_date">
                {{ $t('validation.attributes.start_date') }}
            </base-form-label>

            <base-v-calendar
                v-model:date="startDate"
                :placeholder="$t('auth.placeholders.fill', { attribute: $t('validation.attributes.start_date') })"
                hide-time-header
                is24hr
                mode="time"
            ></base-v-calendar>

            <base-form-input-error>
                <div v-if="form?.invalid('start_date')" class="mt-2 text-danger" data-test="error_start_date_message">
                    {{ form.errors.start_date }}
                </div>
            </base-form-input-error>
        </div>

        <div class="col-span-12 sm:col-span-4">
            <base-form-label for="end_date">
                {{ $t('validation.attributes.end_date') }}
            </base-form-label>

            <base-v-calendar
                v-model:date="endDate"
                :placeholder="$t('auth.placeholders.fill', { attribute: $t('validation.attributes.end_date') })"
                hide-time-header
                is24hr
                mode="time"
            ></base-v-calendar>

            <base-form-input-error>
                <div v-if="form?.invalid('end_date')" class="mt-2 text-danger" data-test="error_end_date_message">
                    {{ form.errors.end_date }}
                </div>
            </base-form-input-error>
        </div>
    </div>
    <!-- End: Date Range-->

    <!-- Begin: Frequency-->
    <div class="col-span-12 sm:col-span-6">
        <base-form-label htmlFor="frequency">
            {{ $t('validation.attributes.frequency') }}
        </base-form-label>

        <base-form-select id="frequency" v-model="frequency" :disabled="!disabled">
            <option value="">{{ $t('none') }}</option>
            <option value="daily">{{ $t('daily') }}</option>
            <option value="weekly">{{ $t('weekly') }}</option>
            <option value="monthly">{{ $t('monthly') }}</option>
        </base-form-select>

        <div v-if="form.errors?.frequency" class="mt-2">
            <base-input-error :message="form.errors.frequency"></base-input-error>
        </div>
    </div>
    <!-- End: Frequency-->

    <!-- Begin: Interval-->
    <div class="col-span-12 sm:col-span-6">
        <base-form-label htmlFor="interval">
            {{ $t('validation.attributes.interval') }}
        </base-form-label>

        <base-form-input
            id="interval"
            v-model="interval"
            :disabled="!disabled"
            :placeholder="$t('placeholders.fill_interval')"
            type="number"
        ></base-form-input>

        <div v-if="form.errors?.interval" class="mt-2">
            <base-input-error :message="form.errors.interval"></base-input-error>
        </div>
    </div>
    <!-- End: Interval-->

    <!-- Begin: Until-->
    <div class="col-span-12 sm:col-span-6">
        <base-form-label htmlFor="until">
            {{ $t('validation.attributes.until') }}
        </base-form-label>

        <base-v-calendar
            id="until"
            v-model:date="until"
            :disabled="!disabled"
            :placeholder="$t('auth.placeholders.fill', { attribute: $t('validation.attributes.until') })"
            mode="date"
            type="text"
        ></base-v-calendar>

        <div v-if="form.errors?.until" class="mt-2">
            <base-input-error :message="form.errors.until"></base-input-error>
        </div>
    </div>
    <!-- End: Until-->
</template>
