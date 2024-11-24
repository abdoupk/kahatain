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
import SvgLoader from '@/Components/Global/SvgLoader.vue'

import { getLeafletMapConfig } from '@/utils/helper'
import { $t } from '@/utils/i18n'
import { getMarkers, setMapMarkers } from '@/utils/leaflet'

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

        positions.value.push(
            ...a.flatMap((zone) =>
                zone.families.map((family) => {
                    return {
                        name: family.name,
                        address: family.address,
                        location: family.location
                    }
                })
            )
        )

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

        const markers = getMarkers(leaflet)

        map.addLayer(markers)

        setMapMarkers(leaflet, markers, positions.value)

        L.geoJSON(zones.value, {
            onEachFeature: function (feature, layer) {
                if (feature.properties && feature.properties.name) {
                    layer.bindPopup(feature.properties.name)
                }
            }
        }).addTo(map)

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
            <svg-loader class="h-5 w-5" name="icon-map"></svg-loader>
        </base-button>
    </base-tippy>
</template>
