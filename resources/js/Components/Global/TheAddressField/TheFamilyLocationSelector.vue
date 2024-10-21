<script lang="ts" setup>
import { PositionType } from '@/types/types'

import { useSettingsStore } from '@/stores/settings'
import 'leaflet/dist/leaflet.css'
import { computed, ref, watch } from 'vue'

import LeafletMapLoader, { Init } from '@/Components/Base/LeafletMapLoader/LeafletMapLoader.vue'

import { extractColor } from '@/utils/colors'
import { getLeafletMapConfig, getMarkerIcon } from '@/utils/helper'

const props = defineProps<{
    location: PositionType
}>()

const emit = defineEmits(['set-location'])

const darkMode = computed(() => useSettingsStore().appearance === 'dark')

const colorScheme = computed(() => useSettingsStore().colorScheme)

const init: Init = async (initializeMap) => {
    const mapInstance = await initializeMap({
        config: {
            ...getLeafletMapConfig(),
            gestureHandling: false,
            attributionControl: false
        }
    })

    if (mapInstance) {
        const { map, leaflet } = mapInstance

        leaflet.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map)

        const color = darkMode.value && colorScheme.value ? extractColor('darkmode-100') : extractColor('primary')

        const mapMarkerSvg = getMarkerIcon(color)

        const addMarker = (location) => {
            const marker = leaflet
                .marker(
                    {
                        lat: parseFloat(location.lat),
                        lng: parseFloat(location.lng)
                    },
                    {
                        draggable: true,
                        icon: leaflet.icon({
                            iconUrl: `data:image/svg+xml;base64,${mapMarkerSvg}`,
                            iconAnchor: leaflet.point(10, 35)
                        })
                    }
                )
                .addTo(map)

            marker.on('click', function () {
                map.removeLayer(marker)

                emit('set-location', { lat: null, lng: null })

                markerAdded.value = false
            })

            emit('set-location', marker.getLatLng())

            marker.on('dragend', function () {
                emit('set-location', marker.getLatLng())
            })

            markerAdded.value = true
        }

        const markerAdded = ref(false)

        if (props.location.lat != null && props.location.lng != null) {
            addMarker(props.location)
        }

        map.on('click', (e) => {
            if (!markerAdded.value) {
                addMarker(e.latlng)
            }
        })

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
