<script lang="ts" setup>
import type { AuthInformation } from '@/types/types'

import TheDeleteAccountForm from '@/Pages/Profile/account/TheDeleteAccountForm.vue'
import ThePasswordForm from '@/Pages/Profile/account/ThePasswordForm.vue'
import TheProfileInformationForm from '@/Pages/Profile/account/TheProfileInformationForm.vue'

defineProps<{
    data: AuthInformation
}>()
</script>

<template>
    <the-profile-information-form :data></the-profile-information-form>

    <the-password-form></the-password-form>

    <the-delete-account-form></the-delete-account-form>
</template>
