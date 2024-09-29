<script lang="ts" setup>
import { useForm } from '@inertiajs/vue3'
import { nextTick, ref } from 'vue'

import BaseButton from '@/Components/Base/button/BaseButton.vue'
import BaseFormInput from '@/Components/Base/form/BaseFormInput.vue'
import BaseFormLabel from '@/Components/Base/form/BaseFormLabel.vue'
import BaseInputError from '@/Components/Base/form/BaseInputError.vue'
import DeleteModal from '@/Components/Global/DeleteModal.vue'

import { $t } from '@/utils/i18n'

const confirmingUserDeletion = ref(false)

const passwordInput = ref<HTMLInputElement | null>(null)

const form = useForm({
    password: ''
})

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true

    nextTick(() => passwordInput.value?.focus())
}

const deleteUser = () => {
    form.delete(route('tenant.profile.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value?.focus(),
        onFinish: () => {
            form.reset()
        }
    })
}

const closeModal = () => {
    confirmingUserDeletion.value = false

    form.reset()
}
</script>

<template>
    <div class="mt-5 border-t">
        <div class="mt-5 px-2">
            <h2 class="text-base/relaxed rtl:text-xl rtl:font-semibold">{{ $t('profile.delete_account') }}</h2>

            <h2 class="mt-0.5 text-sm/4 text-slate-500">
                {{ $t('profile.delete_account_hint') }}
            </h2>

            <base-button class="!mt-2 w-20" variant="danger" @click.prevent="confirmUserDeletion"
                >{{ $t('delete') }}
            </base-button>

            <delete-modal
                :delete-progress="form.processing"
                :open="confirmingUserDeletion"
                @close="confirmingUserDeletion = false"
                @delete="deleteUser"
            >
                <div class="col-span-12 text-start sm:col-span-6">
                    <base-form-label htmlFor="password">
                        {{ $t('profile.delete_account_confirm') }}
                    </base-form-label>

                    <base-form-input
                        id="password"
                        ref="passwordInput"
                        v-model="form.password"
                        :placeholder="$t('auth.placeholders.fill', { attribute: $t('validation.attributes.password') })"
                        class="mt-6 [&[readonly]]:cursor-default [&[readonly]]:bg-white [&[readonly]]:dark:bg-darkmode-800"
                        onfocus="this.removeAttribute('readonly')"
                        readonly
                        type="password"
                    />

                    <div v-if="form.errors?.password" class="mt-2">
                        <base-input-error :message="form.errors.password"></base-input-error>
                    </div>
                </div>
            </delete-modal>
        </div>
    </div>
</template>
