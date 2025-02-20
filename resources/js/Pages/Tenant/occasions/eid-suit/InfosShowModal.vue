<script lang="ts" setup>
import { useOrphansStore } from '@/stores/orphans'

import ShowModal from '@/Components/Global/ShowModal.vue'

import { $t } from '@/utils/i18n'

defineProps<{
    open: boolean
}>()

const emit = defineEmits(['close'])

const orphansStore = useOrphansStore()
</script>

<template>
    <show-modal :open :title="$t('show')" size="lg" @close="emit('close')">
        <template #description>
            <!-- Begin: clothes shop name-->
            <div class="col-span-6">
                <h2 class="rtl:font-semibold">
                    {{ $t('clothes_shop_name') }}
                </h2>

                <h3 class="mt-1 rtl:font-medium">
                    {{ orphansStore.eidSuitInfos.clothes_shop_name || '————' }}
                </h3>
            </div>
            <!-- End: clothes shop name-->

            <!-- Begin: clothes shop phone number-->
            <div class="col-span-6">
                <h2 class="rtl:font-semibold">
                    {{ $t('clothes_shop_phone_number') }}
                </h2>

                <h3 class="mt-1 rtl:font-medium">
                    {{ orphansStore.eidSuitInfos.clothes_shop_phone_number || '————' }}
                </h3>
            </div>
            <!-- End: clothes shop phone number-->

            <!-- Begin: clothes shop address-->
            <div class="col-span-6">
                <h2 class="rtl:font-semibold">
                    {{ $t('clothes_shop_location') }}
                </h2>

                <h3 class="mt-1 rtl:font-medium">
                    {{ orphansStore.eidSuitInfos.clothes_shop_address || '————' }}
                </h3>
            </div>
            <!-- End: clothes shop address-->

            <!-- Begin: shoes shop name-->
            <div class="col-span-6">
                <h2 class="rtl:font-semibold">
                    {{ $t('shoes_shop_name') }}
                </h2>

                <h3 class="mt-1 rtl:font-medium">
                    {{ orphansStore.eidSuitInfos.shoes_shop_name || '————' }}
                </h3>
            </div>
            <!-- End: shoes shop name-->

            <!-- Begin: shoes shop phone number-->
            <div class="col-span-6">
                <h2 class="rtl:font-semibold">
                    {{ $t('shoes_shop_phone_number') }}
                </h2>

                <h3 class="mt-1 rtl:font-medium">
                    {{ orphansStore.eidSuitInfos.shoes_shop_phone_number || '————' }}
                </h3>
            </div>
            <!-- End: shoes shop phone number-->

            <!-- Begin: shoes shop address-->
            <div class="col-span-6">
                <h2 class="rtl:font-semibold">
                    {{ $t('shoes_shop_location') }}
                </h2>

                <h3 class="mt-1 rtl:font-medium">
                    {{ orphansStore.eidSuitInfos.shoes_shop_address || '————' }}
                </h3>
            </div>
            <!-- End: shoes shop address-->

            <!-- Begin: designated member-->
            <div class="col-span-6">
                <h2 class="rtl:font-semibold">
                    {{ $t('designated_member') }}
                </h2>

                <h3 class="mt-1 rtl:font-medium">
                    {{ orphansStore.eidSuitInfos.designated_member?.name || '————' }}
                </h3>
            </div>
            <!-- End: designated member-->

            <!-- Begin: pants completed-->
            <div class="col-span-6">
                <h2 class="rtl:font-semibold">
                    {{ $t('pants_completed') }}
                </h2>

                <h3 class="mt-1 rtl:font-medium">
                    {{ orphansStore.eidSuitInfos.pants_completed ? $t('yes') : $t('no') }}
                </h3>
            </div>
            <!-- End: pants completed-->

            <!-- Begin: shirt completed-->
            <div class="col-span-6">
                <h2 class="rtl:font-semibold">
                    {{ $t('shirt_completed') }}
                </h2>

                <h3 class="mt-1 rtl:font-medium">
                    {{ orphansStore.eidSuitInfos.shirt_completed ? $t('yes') : $t('no') }}
                </h3>
            </div>
            <!-- End: shirt completed-->

            <!-- Begin: shoes completed-->
            <div class="col-span-6">
                <h2 class="rtl:font-semibold">
                    {{ $t('shoes_completed') }}
                </h2>

                <h3 class="mt-1 rtl:font-medium">
                    {{ orphansStore.eidSuitInfos.shoes_completed ? $t('yes') : $t('no') }}
                </h3>
            </div>
            <!-- End: shoes completed-->

            <!-- Begin: note-->
            <div class="col-span-12">
                <h2 class="rtl:font-semibold">
                    {{ $t('notes') }}
                </h2>

                <h3 class="mt-1 rtl:font-medium">
                    {{ orphansStore.eidSuitInfos.note || '————' }}
                </h3>
            </div>
            <!-- End: note-->
        </template>
    </show-modal>
</template>
