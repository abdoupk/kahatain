<script lang="ts" setup>
import { useSettingsStore } from '@/stores/settings'
import { Calendar } from 'v-calendar'
import 'v-calendar/style.css'

import { getLocale } from '@/utils/i18n'

const settingsStore = useSettingsStore()

const currentDate = new Date()

const minDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1)

const maxDate = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0)
</script>

<template>
    <Calendar
        :is-dark="settingsStore.appearance === 'dark'"
        :locale="getLocale()"
        :maxDate
        :minDate
        borderless
        disable-page-swipe
        expanded
        transparent
    ></Calendar>
</template>

<style lang="postcss">
@import '/resources/css/vendors/v-calendar.css';
</style>
