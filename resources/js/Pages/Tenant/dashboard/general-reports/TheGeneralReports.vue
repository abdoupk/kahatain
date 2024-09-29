<script lang="ts" setup>
import type { GeneralReportsType } from '@/types/dashboard'

import ReportBox from '@/Pages/Tenant/dashboard/general-reports/ReportBox.vue'

defineProps<{
    reports: GeneralReportsType
}>()
</script>

<template>
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 2xl:col-span-9">
            <div class="grid grid-cols-12 gap-6">
                <div class="col-span-12 mt-8">
                    <div class="intro-y flex h-10 items-center">
                        <h2 class="me-5 truncate text-lg font-medium rtl:text-xl rtl:font-semibold">
                            {{ $t('statistics.dashboard.general_reports') }}
                        </h2>
                    </div>
                    <div class="mt-5 grid grid-cols-12 gap-6">
                        <report-box
                            :percentageDifference="parseInt(reports.orphans.percentageDifference)"
                            :stat="reports.orphans.total"
                            :title="$t('statistics.dashboard.total_orphans')"
                            icon="icon-hands-holding-child"
                            icon-color="primary"
                        ></report-box>

                        <report-box
                            :percentageDifference="parseInt(reports.families.percentageDifference)"
                            :stat="reports.families.total"
                            :title="$t('statistics.dashboard.total_families')"
                            icon="icon-family"
                            icon-color="dark"
                        ></report-box>

                        <report-box
                            :percentageDifference="parseInt(reports.members.percentageDifference)"
                            :stat="reports.members.total"
                            :title="$t('statistics.dashboard.total_members')"
                            icon="icon-users-gear"
                            icon-color="pending"
                        ></report-box>

                        <report-box
                            :percentageDifference="parseInt(reports.branches.percentageDifference)"
                            :stat="reports.branches.total"
                            :title="$t('statistics.dashboard.total_branches')"
                            icon="icon-branches"
                            icon-color="success"
                        ></report-box>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
