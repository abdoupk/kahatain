<script lang="ts" setup>
import { useSettingsStore } from '@/stores/settings'
import { useZonesStore } from '@/stores/zones'
import L from 'leaflet'
import 'leaflet-fullscreen'
import 'leaflet-fullscreen/dist/leaflet.fullscreen.css'
import 'leaflet-gesture-handling/dist/leaflet-gesture-handling.css'
import 'leaflet/dist/leaflet.css'
import { computed, ref, watch } from 'vue'

import LeafletMapLoader, { Init } from '@/Components/Base/LeafletMapLoader/LeafletMapLoader.vue'
import BaseButton from '@/Components/Base/button/BaseButton.vue'
import BaseTippy from '@/Components/Base/tippy/BaseTippy.vue'
import SvgLoader from '@/Components/SvgLoader.vue'

import { extractColor } from '@/utils/colors'
import { getLeafletMapConfig, getMarkerIcon, getMarkerRegionIcon } from '@/utils/helper'
import { $t } from '@/utils/i18n'

const fullScreen = ref(false)

const darkMode = computed(() => useSettingsStore().appearance === 'dark')

const colorScheme = computed(() => useSettingsStore().colorScheme)

const zonesStore = useZonesStore()

const positions = ref([])

const zones = ref([])

const init: Init = async (initializeMap) => {
    const mapInstance = await initializeMap({
        config: {
            ...getLeafletMapConfig(),
            gestureHandling: false,
            zoomControl: false,
            attributionControl: false,
            fullscreenControl: false
        }
    })

    if (mapInstance) {
        const a = await zonesStore.getZonesWithFamiliesPositions()

        positions.value.push(...a.flatMap((zone) => zone.families.map((family) => family.location)))

        zones.value.push(
            ...a.flatMap((zone) => {
                if (zone.geom !== null) {
                    return {
                        ...zone.geom,
                        properties: { name: zone.name }
                    }
                }

                return []
            })
        )

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

        L.geoJSON(zones.value, {
            onEachFeature: function (feature, layer) {
                if (feature.properties && feature.properties.name) {
                    layer.bindPopup(feature.properties.name)
                }
            }
        }).addTo(map)

        positions.value.map(function (markerElem) {
            if (markerElem?.lat && markerElem?.lng) {
                const marker = leaflet.marker(
                    {
                        lat: parseFloat(markerElem.lat),
                        lng: parseFloat(markerElem.lng)
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
            }
        })

        map.addControl(
            new L.Control.Fullscreen({
                title: {
                    false: $t('view_fullscreen'),
                    true: $t('exit_fullscreen')
                }
            })
        )

        const unwatch = watch([colorScheme, darkMode], () => {
            unwatch()

            init(initializeMap)
        })

        watch(
            () => fullScreen.value,
            () => {
                map.toggleFullscreen()
            }
        )
    }
}
</script>

<template>
    <leaflet-map-loader :darkMode :init></leaflet-map-loader>

    <base-tippy :content="$t('show_zones_in_map')">
        <base-button @click.prevent="fullScreen = !fullScreen">
            <svg-loader name="icon-map" class="h-5 w-5"></svg-loader>
        </base-button>
    </base-tippy>
</template>
