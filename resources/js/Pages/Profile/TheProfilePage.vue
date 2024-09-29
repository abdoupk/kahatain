<script lang="ts" setup>
import type { AuthInformation } from '@/types/types'

import { Head } from '@inertiajs/vue3'

import TheLayout from '@/Layouts/TheLayout.vue'

import TheAccountForm from '@/Pages/Profile/account/TheAccountForm.vue'
import TheAppearanceForm from '@/Pages/Profile/appearance/TheAppearanceForm.vue'
import TheNotificationsForm from '@/Pages/Profile/notifications/TheNotificationsForm.vue'

import BaseTab from '@/Components/Base/headless/Tab/BaseTab.vue'
import BaseTabButton from '@/Components/Base/headless/Tab/BaseTabButton.vue'
import BaseTabGroup from '@/Components/Base/headless/Tab/BaseTabGroup.vue'
import BaseTabList from '@/Components/Base/headless/Tab/BaseTabList.vue'
import BaseTabPanel from '@/Components/Base/headless/Tab/BaseTabPanel.vue'
import BaseTabPanels from '@/Components/Base/headless/Tab/BaseTabPanels.vue'
import SvgLoader from '@/Components/SvgLoader.vue'

import { $t } from '@/utils/i18n'

defineOptions({
    layout: TheLayout
})

defineProps<{
    data: AuthInformation
}>()
</script>

<template>
    <Head :title="$t('breadcrumb.profile')"></Head>

    <div class="intro-y mt-8 flex items-center">
        <h2 class="me-auto text-lg font-medium ltr:capitalize">{{ $t('breadcrumb.profile') }}</h2>
    </div>

    <div class="intro-y @container">
        <base-tab-group class="box mt-5 grid w-full grid-cols-12 gap-6 p-5 @3xl:w-11/12">
            <div class="col-span-12 text-base/relaxed @3xl:col-span-3">
                <base-tab-list class="flex @3xl:block" variant="pills">
                    <base-tab>
                        <base-tab-button
                            as="button"
                            class="flex w-full content-around items-center justify-center py-2"
                            type="button"
                        >
                            <svg-loader name="icon-user"></svg-loader>

                            <span class="ms-2"> {{ $t('account') }}</span>
                        </base-tab-button>
                    </base-tab>

                    <base-tab>
                        <base-tab-button
                            as="button"
                            class="flex w-full content-around items-center justify-center py-2"
                            type="button"
                        >
                            <svg-loader name="icon-brush"></svg-loader>

                            <span class="ms-2"> {{ $t('appearance') }}</span>
                        </base-tab-button>
                    </base-tab>

                    <base-tab>
                        <base-tab-button
                            as="button"
                            class="flex w-full content-around items-center justify-center py-2"
                            type="button"
                        >
                            <svg-loader class="ms-3.5" name="icon-bell"></svg-loader>

                            <span class="ms-2"> {{ $t('notifications') }}</span>
                        </base-tab-button>
                    </base-tab>
                </base-tab-list>
            </div>

            <div class="col-span-12 @3xl:col-span-9">
                <base-tab-panels>
                    <base-tab-panel>
                        <the-account-form :data></the-account-form>
                    </base-tab-panel>

                    <base-tab-panel>
                        <the-appearance-form></the-appearance-form>
                    </base-tab-panel>

                    <base-tab-panel>
                        <the-notifications-form></the-notifications-form>
                    </base-tab-panel>
                </base-tab-panels>
            </div>
        </base-tab-group>
    </div>
</template>
