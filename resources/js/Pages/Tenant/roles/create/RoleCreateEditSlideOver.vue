<script lang="ts" setup>
import { useRolesStore } from '@/stores/roles'
import { router } from '@inertiajs/vue3'
import { useForm } from 'laravel-precognition-vue'
import { computed, ref, watch } from 'vue'

import BaseFormInput from '@/Components/Base/form/BaseFormInput.vue'
import BaseFormLabel from '@/Components/Base/form/BaseFormLabel.vue'
import BaseInputError from '@/Components/Base/form/BaseInputError.vue'
import BaseFormCheckInput from '@/Components/Base/form/form-check/BaseFormCheckInput.vue'
import BaseFormSwitch from '@/Components/Base/form/form-switch/BaseFormSwitch.vue'
import BaseFormSwitchInput from '@/Components/Base/form/form-switch/BaseFormSwitchInput.vue'
import BaseFormSwitchLabel from '@/Components/Base/form/form-switch/BaseFormSwitchLabel.vue'
import CreateEditSlideOver from '@/Components/Global/CreateEditSlideOver.vue'
import SuccessNotification from '@/Components/Global/SuccessNotification.vue'

import { permissions } from '@/utils/constants'
import { $t, $tc } from '@/utils/i18n'

defineProps<{
    open: boolean
}>()

// Get the roles store
const rolesStore = useRolesStore()

// Initialize a ref for loading state
const loading = ref(false)

const form = computed(() => {
    if (rolesStore.role.uuid) {
        return useForm('put', route('tenant.roles.update', rolesStore.role.uuid), { ...rolesStore.role })
    }

    return useForm('post', route('tenant.roles.store'), { ...rolesStore.role })
})

const showSuccessNotification = ref(false)

const notificationTitle = computed(() => {
    return rolesStore.role.uuid ? $t('successfully_updated') : $t('successfully_created', { attribute: $t('the_role') })
})

// Define custom event emitter for 'close' event
const emit = defineEmits(['close'])

// Function to handle success and close the slideover after a delay
const handleSuccess = () => {
    setTimeout(() => {
        router.get(
            route('tenant.roles.index'),
            {},
            {
                only: ['roles'],
                preserveState: true
            }
        )
    }, 200)

    emit('close')
}

const handleSubmit = async () => {
    loading.value = true

    try {
        await form.value
            .submit({
                onSuccess() {
                    showSuccessNotification.value = true
                },
                onFinish() {
                    showSuccessNotification.value = false
                }
            })
            .then(handleSuccess)
    } finally {
        loading.value = false
    }
}

// Compute the slideover title based on the role id
const modalTitle = computed(() => {
    return rolesStore.role.uuid
        ? $t('modal_update_title', { attribute: $t('the_role') })
        : $tc('add new', 1, { attribute: $t('role') })
})

// Initialize a ref for the first input element
const firstInputRef = ref<HTMLElement>()

// Compute the slideover type based on the role id
const modalType = computed(() => {
    return rolesStore.role.uuid ? 'update' : 'create'
})

const checkAll = (model: keyof typeof permissions, checked: boolean) => {
    const suffix = model === 'students' || model === 'inventory' ? '' : `_${model}`

    permissions[model].forEach((permission: string) => {
        rolesStore.role.permissions[`${permission}${suffix}`] = checked
    })
}

const handleCheckboxUpdate = (key: string, permission: string, value: boolean) => {
    if (key === 'list' && !value) {
        permissions[permission].forEach((key: string) => {
            rolesStore.role.permissions[`${key}_${permission}`] = false
        })
    } else if (key !== 'list' && value) {
        if (permissions[permission].includes('list')) rolesStore.role.permissions[`list_${permission}`] = true
    }

    rolesStore.role.permissions = Object.assign(form.value.permissions, {
        [`${key}_${permission}`]: value
    })
}

const handleCheckboxUpdateForInventory = (permission: string, value: boolean) => {
    rolesStore.role.permissions[permission] = value

    if (permission === 'list_items' && !value) {
        permissions['inventory'].forEach((_key: string) => {
            rolesStore.role.permissions[_key] = false
        })
    } else {
        rolesStore.role.permissions['list_items'] = true
    }

    rolesStore.role.permissions = Object.assign(form.value.permissions, {
        [permission]: value
    })
}

const handleCheckboxUpdateForStudents = (permission: string, value: boolean) => {
    rolesStore.role.permissions[permission] = value

    if (permission === 'list_students' && !value) {
        permissions['students'].forEach((_key: string) => {
            rolesStore.role.permissions[_key] = false
        })
    } else {
        rolesStore.role.permissions['list_students'] = true
    }

    rolesStore.role.permissions = Object.assign(form.value.permissions, {
        [permission]: value
    })
}

watch(
    () => rolesStore.role,
    (value) => {
        form.value.setData(value)
    },
    { deep: true }
)
</script>

<template>
    <create-edit-slide-over
        :focusable-input="firstInputRef"
        :loading
        :open
        :slideover-type="modalType"
        :title="modalTitle"
        size="xl"
        @close="emit('close')"
        @handle-submit="handleSubmit"
    >
        <template #description>
            <div class="w-3/5">
                <base-form-label htmlFor="name">
                    {{ $t('validation.attributes.role_name') }}
                </base-form-label>

                <base-form-input
                    id="name"
                    ref="firstInputRef"
                    v-model="rolesStore.role.name"
                    :placeholder="$t('auth.placeholders.fill', { attribute: $t('validation.attributes.role_name') })"
                    type="text"
                />

                <div v-if="form.errors?.name" class="mt-2">
                    <base-input-error :message="form.errors.name"></base-input-error>
                </div>
            </div>

            <div class="col-span-12 mt-6">
                <div v-for="(permissionMaps, key, index) in permissions" :key="index">
                    <div class="my-2 flex justify-between">
                        <h2 class="mb-2 mt-2 text-base/relaxed ltr:font-medium rtl:font-bold">
                            {{ $t(`the_${key}`) }}
                        </h2>

                        <!--@vue-ignore-->
                        <base-form-check-input
                            :id="key"
                            class="mt-3"
                            type="checkbox"
                            @change="checkAll(key, $event.target?.checked)"
                        ></base-form-check-input>
                    </div>

                    <div class="grid grid-cols-2 gap-4 md:grid-cols-3">
                        <div v-for="permission in permissionMaps" :key="permission">
                            <base-form-switch>
                                <base-form-switch-input
                                    v-if="key === 'inventory'"
                                    :id="`${permission}_${key}`"
                                    :model-value="rolesStore.role.permissions[permission]"
                                    type="checkbox"
                                    @update:model-value="handleCheckboxUpdateForInventory(permission, $event)"
                                ></base-form-switch-input>

                                <base-form-switch-input
                                    v-else-if="key === 'students'"
                                    :id="`${permission}_${key}`"
                                    :model-value="rolesStore.role.permissions[permission]"
                                    type="checkbox"
                                    @update:model-value="handleCheckboxUpdateForStudents(permission, $event)"
                                ></base-form-switch-input>

                                <base-form-switch-input
                                    v-else
                                    :id="`${permission}_${key}`"
                                    :model-value="rolesStore.role.permissions[`${permission}_${key}`]"
                                    type="checkbox"
                                    @update:model-value="handleCheckboxUpdate(permission, key, $event)"
                                ></base-form-switch-input>

                                <base-form-switch-label :for="`${permission}_${key}`" class="whitespace-nowrap">
                                    <template v-if="permission === 'list'">
                                        {{
                                            $t('permissions.list', {
                                                attribute: $t(`the_${key}`)
                                            })
                                        }}
                                    </template>

                                    <template v-else>
                                        {{ `${$t(`permissions.${permission}`)}` }}
                                    </template>
                                </base-form-switch-label>
                            </base-form-switch>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </create-edit-slide-over>

    <success-notification :open="showSuccessNotification" :title="notificationTitle"></success-notification>
</template>
