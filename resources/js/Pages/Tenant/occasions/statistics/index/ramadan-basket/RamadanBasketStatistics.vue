<script lang="ts" setup>
import { RamadanBasketStatisticsType } from '@/types/statistics'

import BaseVerticalBarChart from '@/Components/Base/chart/BaseVerticalBarChart.vue'
import TheNoDataChart from '@/Components/Global/TheNoDataChart.vue'

import { isEmpty } from '@/utils/helper'

const props = defineProps<{ ramadanBasket: RamadanBasketStatisticsType }>()

const labels = !isEmpty(props.ramadanBasket)
    ? Object.keys(props.ramadanBasket[Object.keys(props.ramadanBasket)[0]])
    : []

const datasets = !isEmpty(props.ramadanBasket)
    ? Object.keys(props.ramadanBasket).map((year) => {
          return {
              label: year,
              data: Object.values(props.ramadanBasket[year])
          }
      })
    : []
</script>

<template>
    <base-vertical-bar-chart
        v-if="!isEmpty(props.ramadanBasket)"
        :datasets
        :height="300"
        :labels
    ></base-vertical-bar-chart>

    <the-no-data-chart v-else></the-no-data-chart>
</template>
