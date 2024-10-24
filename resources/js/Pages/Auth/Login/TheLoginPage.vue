<script lang="ts" setup>
import { Head } from '@inertiajs/vue3'

import TheLoginForm from '@/Pages/Auth/Login/TheLoginForm.vue'
import TheAuthLayout from '@/Pages/Auth/TheAuthLayout.vue'

import { $t } from '@/utils/i18n'

defineProps<{
    canResetPassword?: boolean
    status?: string
}>()
</script>

<template>
    <Head :title="$t('auth.Login')" />

    <the-auth-layout>
        <the-login-form></the-login-form>
    </the-auth-layout>
</template>
