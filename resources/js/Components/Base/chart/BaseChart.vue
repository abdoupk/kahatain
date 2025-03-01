<script lang="ts" setup>
import { useWindowSize } from '@vueuse/core'
import ChartJs, { type ChartConfiguration } from 'chart.js/auto'
import { type CanvasHTMLAttributes, inject, onMounted, ref, watch } from 'vue'

export interface ChartElement extends HTMLCanvasElement {
    instance: ChartJs
}

export type ProvideChart = (el: ChartElement) => void

interface ChartProps extends /* @vue-ignore */ CanvasHTMLAttributes, /* @vue-ignore */ ChartConfiguration {
    width?: number
    height?: number
    type: ChartConfiguration['type']
    data: ChartConfiguration['data']
    options: ChartConfiguration['options']
    refKey?: string
}

defineOptions({
    inheritAttrs: false
})

const props = defineProps<ChartProps>()

const chartRef = ref<ChartElement>()

const { width: windowWidth } = useWindowSize()

const init = (el: ChartElement, props: ChartProps) => {
    const canvas = el?.getContext('2d')

    if (canvas) {
        // Attach ChartJs instance
        el.instance = new ChartJs(canvas, {
            type: props.type,
            data: props.data,
            options: props.options
        })
    }
}

const bindInstance = (el: ChartElement) => {
    if (props.refKey) {
        const bind = inject<ProvideChart>(`bind[${props.refKey}]`)

        if (bind) {
            bind(el)
        }
    }
}

onMounted(() => {
    if (chartRef.value) {
        bindInstance(chartRef.value)

        init(chartRef.value, props)
    }

    watch(props, () => {
        if (chartRef.value) {
            chartRef.value.instance.data = props.data

            if (props.options) {
                chartRef.value.instance.options = props.options
            }

            chartRef.value.instance.update()
        }
    })
})
</script>

<template>
    <div
        :style="{
            width: `${width}px`,
            height: windowWidth < 512 ? '239px' : `${height}px`
        }"
    >
        <canvas ref="chartRef" :class="$attrs.class"></canvas>
    </div>
</template>
