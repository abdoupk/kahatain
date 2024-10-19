<script lang="ts" setup>
import { FamiliesForMapType } from '@/types/dashboard'

import { useSettingsStore } from '@/stores/settings'
import 'leaflet-gesture-handling/dist/leaflet-gesture-handling.css'
import 'leaflet/dist/leaflet.css'
import { computed, watch } from 'vue'

import LeafletMapLoader, { Init } from '@/Components/Base/LeafletMapLoader/LeafletMapLoader.vue'

import { extractColor } from '@/utils/colors'

const props = defineProps<{
    familiesForMap: FamiliesForMapType[]
}>()

const darkMode = computed(() => useSettingsStore().appearance === 'dark')

const colorScheme = computed(() => useSettingsStore().colorScheme)

const init: Init = async (initializeMap) => {
    const mapInstance = await initializeMap({
        config: {
            center: [33.6854, 1.0304],
            zoom: 13,
            minZoom: 6,
            gestureHandling: true,
            zoomControl: false,
            attributionControl: false,
            gestureHandlingOptions: {
                duration: 5000,
                touchDuration: 5000,
                text: {
                    touch: 'Hey bro, use two fingers to move the map',
                    scroll: 'Hey bro, use ctrl + scroll to zoom the map',
                    scrollMac: 'Hey bro, use \u2318 + scroll to zoom the map'
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

                const mapMarkerRegionSvg =
                    window.btoa(`<svg xmlns="http://www.w3.org/2000/svg" width="55.066" height="47.691" viewBox="0 0 55.066 47.691">
                <g id="Group_15" data-name="Group 15" transform="translate(-319.467 -83.991)">
                  <g id="Group_14" data-name="Group 14">
                    <path id="Intersection_4" data-name="Intersection 4" d="M12.789,17.143a15,15,0,0,1,20.7,0l-1.6,2.141-.018-.018a12.352,12.352,0,0,0-17.469,0l-.018.018Z" transform="translate(323.861 78.999)" fill="${color}" opacity="0.845"/>
                    <path id="Intersection_5" data-name="Intersection 5" d="M10.384,13.919a19,19,0,0,1,25.511,0l-2.016,2.7a15.647,15.647,0,0,0-21.479,0Z" transform="translate(323.861 78.999)" fill="${color}" opacity="0.652"/>
                    <path id="Intersection_6" data-name="Intersection 6" d="M7.982,10.7a22.978,22.978,0,0,1,30.313,0l-2,2.679a19.652,19.652,0,0,0-26.316,0Z" transform="translate(323.861 78.999)" fill="${color}" opacity="0.453"/>
                  </g>
                  <g id="Group_13" data-name="Group 13" transform="translate(427.806 461.061) rotate(-120)">
                    <path id="Intersection_4-2" data-name="Intersection 4" d="M12.789,17.143a15,15,0,0,1,20.7,0l-1.6,2.141-.018-.018a12.352,12.352,0,0,0-17.469,0l-.018.018Z" transform="translate(323.861 78.999)" fill="${color}" opacity="0.845"/>
                    <path id="Intersection_5-2" data-name="Intersection 5" d="M10.384,13.919a19,19,0,0,1,25.511,0l-2.016,2.7a15.647,15.647,0,0,0-21.479,0Z" transform="translate(323.861 78.999)" fill="${color}" opacity="0.652"/>
                    <path id="Intersection_6-2" data-name="Intersection 6" d="M7.982,10.7a22.978,22.978,0,0,1,30.313,0l-2,2.679a19.652,19.652,0,0,0-26.316,0Z" transform="translate(323.861 78.999)" fill="${color}" opacity="0.453"/>
                  </g>
                  <circle id="Ellipse_9" data-name="Ellipse 9" cx="11" cy="11" r="11" transform="translate(336 96)" fill="${color}"/>
                  <g id="Group_12" data-name="Group 12" transform="translate(613.194 -139.96) rotate(120)">
                    <path id="Intersection_4-3" data-name="Intersection 4" d="M12.789,17.143a15,15,0,0,1,20.7,0l-1.6,2.141-.018-.018a12.352,12.352,0,0,0-17.469,0l-.018.018Z" transform="translate(323.861 78.999)" fill="${color}" opacity="0.845"/>
                    <path id="Intersection_5-3" data-name="Intersection 5" d="M10.384,13.919a19,19,0,0,1,25.511,0l-2.016,2.7a15.647,15.647,0,0,0-21.479,0Z" transform="translate(323.861 78.999)" fill="${color}" opacity="0.652"/>
                    <path id="Intersection_6-3" data-name="Intersection 6" d="M7.982,10.7a22.978,22.978,0,0,1,30.313,0l-2,2.679a19.652,19.652,0,0,0-26.316,0Z" transform="translate(323.861 78.999)" fill="${color}" opacity="0.453"/>
                  </g>
                </g>
              </svg>
            `)

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

        const mapMarkerSvg =
            window.btoa(`<svg xmlns="http://www.w3.org/2000/svg" width="20" height="31.063" viewBox="0 0 20 31.063">
              <g id="Group_16" data-name="Group 16" transform="translate(-408 -150.001)">
                <path id="Subtraction_21" data-name="Subtraction 21" d="M10,31.064h0L1.462,15.208A10,10,0,1,1,20,10a9.9,9.9,0,0,1-1.078,4.522l-.056.108c-.037.071-.077.146-.121.223L10,31.062ZM10,2a8,8,0,1,0,8,8,8,8,0,0,0-8-8Z" transform="translate(408 150)" fill="${color}"/>
                <circle id="Ellipse_26" data-name="Ellipse 26" cx="6" cy="6" r="6" transform="translate(412 154)" fill="${color}"/>
              </g>
            </svg>
          `)

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
