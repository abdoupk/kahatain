<script lang="ts" setup>
import { PositionType } from '@/types/types'

import { useSettingsStore } from '@/stores/settings'
import { usePage } from '@inertiajs/vue3'
import 'leaflet/dist/leaflet.css'
import { computed, ref, watch } from 'vue'

import LeafletMapLoader, { Init } from '@/Components/Base/LeafletMapLoader/LeafletMapLoader.vue'

import { extractColor } from '@/utils/colors'

const props = defineProps<{
    location: PositionType
}>()

const emit = defineEmits(['set-location'])

const darkMode = computed(() => useSettingsStore().appearance === 'dark')

const colorScheme = computed(() => useSettingsStore().colorScheme)

const init: Init = async (initializeMap) => {
    const mapInstance = await initializeMap({
        config: {
            center: [usePage().props.association_coordinates.lat, usePage().props.association_coordinates.lng],
            zoom: 13,
            minZoom: 6,
            gestureHandling: false,
            attributionControl: false
        }
    })

    if (mapInstance) {
        const { map, leaflet } = mapInstance

        leaflet.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map)

        const color = darkMode.value && colorScheme.value ? extractColor('darkmode-100') : extractColor('primary')

        const mapMarkerSvg =
            window.btoa(`<svg xmlns="http://www.w3.org/2000/svg" width="20" height="31.063" viewBox="0 0 20 31.063">
              <g id="Group_16" data-name="Group 16" transform="translate(-408 -150.001)">
                <path id="Subtraction_21" data-name="Subtraction 21" d="M10,31.064h0L1.462,15.208A10,10,0,1,1,20,10a9.9,9.9,0,0,1-1.078,4.522l-.056.108c-.037.071-.077.146-.121.223L10,31.062ZM10,2a8,8,0,1,0,8,8,8,8,0,0,0-8-8Z" transform="translate(408 150)" fill="${color}"/>
                <circle id="Ellipse_26" data-name="Ellipse 26" cx="6" cy="6" r="6" transform="translate(412 154)" fill="${color}"/>
              </g>
            </svg>
          `)

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
