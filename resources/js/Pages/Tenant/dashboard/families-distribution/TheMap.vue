<script lang="ts" setup>
import { FamiliesForMapType } from '@/types/dashboard'

import { useSettingsStore } from '@/stores/settings'
import 'leaflet-gesture-handling/dist/leaflet-gesture-handling.css'
import 'leaflet/dist/leaflet.css'
import { computed, watch } from 'vue'

import LeafletMapLoader, { Init } from '@/Components/Base/LeafletMapLoader/LeafletMapLoader.vue'

import { extractColor } from '@/utils/colors'
import { getLeafletMapConfig, getMarkerIcon, getMarkerRegionIcon } from '@/utils/helper'
import { $t } from '@/utils/i18n'

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
                duration: 10000,
                touchDuration: 10000,
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

        const markers = leaflet.markerClusterGroup({
            maxClusterRadius: 30,
            iconCreateFunction: function (cluster) {
                const color =
                    darkMode.value && colorScheme.value
                        ? extractColor('darkmode-100', 0.6)
                        : extractColor('primary', 0.8)

                const mapMarkerRegionSvg = getMarkerRegionIcon(color)

                return leaflet.divIcon({
                    html: `<div class="relative w-full h-full">
                  <div class="absolute inset-0 flex items-center justify-center ms-1.5 mb-0.5 font-medium text-white">${cluster.getChildCount()}</div>

                  <img class="w-full h-full" src="data:image/svg+xml;base64,${mapMarkerRegionSvg}" alt="">
                </div>`,
                    className: '',
                    iconSize: leaflet.point(42, 42),
                    iconAnchor: leaflet.point(20, 45)
                })
            },
            spiderfyOnMaxZoom: false,
            showCoverageOnHover: false
        })

        map.addLayer(markers)

        const color = darkMode.value && colorScheme.value ? extractColor('darkmode-100') : extractColor('primary')

        const mapMarkerSvg = getMarkerIcon(color)

        props.familiesForMap.map(function (markerElem) {
            const marker = leaflet.marker(
                {
                    lat: parseFloat(markerElem.location.lat),
                    lng: parseFloat(markerElem.location.lng)
                },
                {
                    title: markerElem.name,
                    icon: leaflet.icon({
                        iconUrl: `data:image/svg+xml;base64,${mapMarkerSvg}`,
                        iconAnchor: leaflet.point(10, 35)
                    })
                }
            )

            marker.bindPopup(`
                        <div class="flex flex-row text-start">
                          <div class="flex-1">
                            <div class="text-lg font-medium text-primary dark:text-slate-300 xl:text-xl"> ${markerElem.name} </div>
                            <div class="mt-0.5 text-slate-500 ltr:capitalize">${markerElem.address}</div>
                          </div>
                        </div>`)

            markers.addLayer(marker)
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
