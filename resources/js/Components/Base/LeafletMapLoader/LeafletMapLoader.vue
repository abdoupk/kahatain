<script lang="ts" setup>
import { type LeafletElement, type MapConfig, initializeMap } from './leaflet-map-loader'

import { type HTMLAttributes, onMounted, ref } from 'vue'

export type Init = (callback: (mapConfig: MapConfig) => ReturnType<typeof initializeMap> | undefined) => void

interface LeafletMapLoaderProps extends /* @vue-ignore */ HTMLAttributes {
    init: Init
    darkMode?: boolean
}

const props = defineProps<LeafletMapLoaderProps>()

const mapRef = ref<LeafletElement>()

onMounted(() => {
    props.init((mapConfig) => {
        if (mapRef.value) {
            return initializeMap(mapRef.value, mapConfig)
        }
    })
})
</script>

<template>
    <div
        :class="{
            // '[&_.leaflet-tile-pane]:saturate-[.3]': !props.darkMode,
            '[&_.leaflet-tile-pane]:brightness-90 [&_.leaflet-tile-pane]:grayscale [&_.leaflet-tile-pane]:hue-rotate-15 [&_.leaflet-tile-pane]:invert':
                props.darkMode
        }"
    >
        <div ref="mapRef" class="h-full w-full rounded-md"></div>
    </div>
</template>

<style lang="postcss">
@import 'leaflet/dist/leaflet.css';

.leaflet-control-attribution {
    display: none !important;
}

.dark .leaflet-container {
    background: #282828;
}
</style>
