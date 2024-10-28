<script lang="ts" setup>
import { FamiliesForMapType } from '@/types/dashboard'

import { useSettingsStore } from '@/stores/settings'
import 'leaflet-gesture-handling/dist/leaflet-gesture-handling.css'
import 'leaflet/dist/leaflet.css'
import { computed, watch } from 'vue'

import LeafletMapLoader, { Init } from '@/Components/Base/LeafletMapLoader/LeafletMapLoader.vue'

import { getLeafletMapConfig } from '@/utils/helper'
import { $t } from '@/utils/i18n'
import { getMarkers, setMapMarkers } from '@/utils/leaflet'

const props = defineProps<{
    familiesForMap: FamiliesForMapType[]
}>()

const darkMode = computed(() => useSettingsStore().appearance === 'dark')

const colorScheme = computed(() => useSettingsStore().colorScheme)

const init: Init = async (initializeMap) => {
    const mapInstance = await initializeMap({
        config: {
            ...getLeafletMapConfig(),
            gestureHandling: true,
            zoomControl: false,
            attributionControl: false,
            gestureHandlingOptions: {
                duration: 5000,
                touchDuration: 5000,
                text: {
                    touch: $t('leaflet.touch'),
                    scroll: $t('leaflet.scroll'),
                    scrollMac: $t('leaflet.scrollMac')
                }
            }
        }
    })

    if (mapInstance) {
        const { map, leaflet } = mapInstance

        leaflet.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map)

        const markers = getMarkers(leaflet)

        map.addLayer(markers)

        setMapMarkers(leaflet, markers, props.familiesForMap)

        const unwatch = watch([colorScheme, darkMode], () => {
            unwatch()

            init(initializeMap)
        })
    }
}
</script>

<template>
    <leaflet-map-loader :darkMode :init></leaflet-map-loader>
</template>
