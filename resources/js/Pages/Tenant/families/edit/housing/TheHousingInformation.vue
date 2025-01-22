<script lang="ts" setup>
import type { FamilyEditHousingType, FurnishingType } from '@/types/families'

import { ref } from 'vue'

import FurnishingsEditForm from '@/Pages/Tenant/families/edit/housing/FurnishingsEditForm.vue'
import HousingEditForm from '@/Pages/Tenant/families/edit/housing/HousingEditForm.vue'

import SuccessNotification from '@/Components/Global/SuccessNotification.vue'

defineProps<{
    housing: FamilyEditHousingType
    furnishings: FurnishingType
}>()

const updateSuccess = ref(false)
</script>

<template>
    <!-- BEGIN: Housing Information -->
    <housing-edit-form :housing @success="updateSuccess = true"></housing-edit-form>
    <!-- END: Housing Information -->

    <!-- BEGIN: Furnishings Information -->
    <furnishings-edit-form
        :family-id="housing.family_id"
        :furnishings
        @success="updateSuccess = true"
    ></furnishings-edit-form>
    <!-- END: Furnishings Information -->

    <success-notification :open="updateSuccess" :title="$t('successfully_updated')"></success-notification>
</template>
