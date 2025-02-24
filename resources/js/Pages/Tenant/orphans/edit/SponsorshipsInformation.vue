<script lang="ts" setup>
import type { OrphanUpdateFormType } from '@/types/orphans'

import { useForm } from 'laravel-precognition-vue'
import { reactive, ref } from 'vue'

import BaseButton from '@/Components/Base/button/BaseButton.vue'
import BaseFormSwitch from '@/Components/Base/form/form-switch/BaseFormSwitch.vue'
import BaseFormSwitchInput from '@/Components/Base/form/form-switch/BaseFormSwitchInput.vue'
import BaseFormSwitchLabel from '@/Components/Base/form/form-switch/BaseFormSwitchLabel.vue'
import SpinnerButtonLoader from '@/Components/Global/SpinnerButtonLoader.vue'
import SuccessNotification from '@/Components/Global/SuccessNotification.vue'

import { omit } from '@/utils/helper'

const props = defineProps<{
    orphan: OrphanUpdateFormType
}>()

const inputs = reactive(omit(props.orphan.sponsorships, ['id']))

const form = useForm('put', route('tenant.orphans.sponsorships-update', props.orphan.id), inputs)

const updateSuccess = ref(false)

const submit = () => {
    form.submit({
        onSuccess() {
            updateSuccess.value = true
        },
        onFinish() {
            updateSuccess.value = false
        }
    })
}
</script>

<template>
    <!-- BEGIN: Sponsorships Information -->
    <div class="intro-y box col-span-12 @container 2xl:col-span-9">
        <div class="flex items-center border-b border-slate-200/60 px-5 py-5 dark:border-darkmode-400 sm:py-3">
            <h2 class="me-auto text-xl font-bold">{{ $t('orphan_sponsorship') }}</h2>
        </div>

        <form @submit.prevent="submit">
            <div class="grid grid-cols-12 gap-4 p-5">
                <div
                    v-for="(sponsorship, key) in omit(orphan.sponsorships, ['id'])"
                    :key
                    class="col-span-12 @xl:col-span-6"
                >
                    <base-form-switch class="text-lg">
                        <base-form-switch-input
                            :id="String(key)"
                            v-model="form[key]"
                            type="checkbox"
                        ></base-form-switch-input>

                        <base-form-switch-label :htmlFor="key">
                            {{ $t(`sponsorships.${key}`) }}
                        </base-form-switch-label>
                    </base-form-switch>
                </div>

                <base-button :disabled="form.processing" class="col-span-12 !mt-0 w-20" type="submit" variant="primary">
                    {{ $t('save') }}

                    <spinner-button-loader :show="form.processing" class="ms-auto"></spinner-button-loader>
                </base-button>
            </div>
        </form>
    </div>
    <!-- END: Sponsorships Information -->

    <success-notification :open="updateSuccess" :title="$t('successfully_updated')"></success-notification>
</template>
