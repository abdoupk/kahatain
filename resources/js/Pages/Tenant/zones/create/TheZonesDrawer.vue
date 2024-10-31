<script lang="ts" setup>
import { FamiliesForMapType } from '@/types/dashboard'

import { useSettingsStore } from '@/stores/settings'
import L from 'leaflet'
import 'leaflet-draw'
import 'leaflet-draw/dist/leaflet.draw.css'
import { computed, watch } from 'vue'

import LeafletMapLoader, { Init } from '@/Components/Base/LeafletMapLoader/LeafletMapLoader.vue'

import { getLeafletMapConfig } from '@/utils/helper'
import { $t, getLocale } from '@/utils/i18n'
import { drawLocal, getMarkers, setMapMarkers } from '@/utils/leaflet'

const props = defineProps<{
    familiesForMap: FamiliesForMapType[]
    zone?: object
}>()

const emit = defineEmits(['set-zone', 'close'])

const darkMode = computed(() => useSettingsStore().appearance === 'dark')

const colorScheme = computed(() => useSettingsStore().colorScheme)

const init: Init = async (initializeMap) => {
    const mapInstance = await initializeMap({
        config: {
            ...getLeafletMapConfig(),
            gestureHandling: false,
            zoomControl: false,
            attributionControl: false
        }
    })

    if (mapInstance) {
        const { map, leaflet } = mapInstance

        leaflet.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map)

        const drawnItems = new L.FeatureGroup()

        let drawControl = new L.Control.Draw({
            edit: {
                featureGroup: drawnItems,
                remove: true
            },
            draw: {
                polygon: true,
                polyline: false,
                rectangle: false,
                circle: false,
                marker: false,
                circlemarker: false
            }
        })

        const enableDrawing = () => {
            drawControl.setDrawingOptions({
                polygon: true,
                polyline: false,
                rectangle: true,
                circle: true,
                marker: false,
                circlemarker: false
            })

            map.addControl(drawControl)
        }

        // Function to disable drawing
        const disableDrawing = () => {
            drawControl.setDrawingOptions({
                polygon: false,
                polyline: false,
                rectangle: false,
                circle: false,
                marker: false,
                circlemarker: false
            })

            map.addControl(drawControl)
        }

        const markers = getMarkers(leaflet)

        map.addLayer(markers)

        setMapMarkers(leaflet, markers, props.familiesForMap)

        map.addLayer(drawnItems)

        if (props.zone) {
            L.geoJSON(props.zone, {
                onEachFeature: function (feature, layer) {
                    drawnItems.addLayer(layer)
                }
            }).addTo(drawnItems)

            disableDrawing()
        }

        let zoomControl = new L.Control.Zoom({
            zoomInTitle: $t('zoom_in'),
            zoomInText: '+',
            zoomOutTitle: $t('zoom_out'),
            zoomOutText: '-',
            position: 'topleft'
        })

        L.drawLocal = drawLocal[getLocale()]

        L.tooltip({
            opacity: 1
        })

        map.addControl(zoomControl)

        map.addLayer(drawnItems)

        map.addControl(drawControl)

        map.on('draw:created', function (e) {
            let layer = e.layer

            drawnItems.addLayer(layer)

            disableDrawing()

            emit('set-zone', e.layer.toGeoJSON())
        })

        map.on('draw:deleted', function () {
            if (drawnItems.getLayers().length === 0) {
                enableDrawing()

                emit('set-zone', null)
            }
        })

        map.on('draw:edited', function (e) {
            e.layers.eachLayer(function (layer) {
                emit('set-zone', layer.toGeoJSON())
            })
        })

        const unwatch = watch([colorScheme, darkMode], () => {
            unwatch()

            init(initializeMap)
        })
    }
}
</script>

<template>
    <leaflet-map-loader :darkMode :init dir="ltr"></leaflet-map-loader>
</template>
