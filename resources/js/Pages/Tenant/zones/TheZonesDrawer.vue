<script lang="ts" setup>
import { FamiliesForMapType } from '@/types/dashboard'

import { useSettingsStore } from '@/stores/settings'
import L from 'leaflet'
import 'leaflet-draw'
import 'leaflet-draw/dist/leaflet.draw.css'
import { computed, watch } from 'vue'

import LeafletMapLoader, { Init } from '@/Components/Base/LeafletMapLoader/LeafletMapLoader.vue'

import { extractColor } from '@/utils/colors'
import { getLeafletMapConfig, getMarkerIcon, getMarkerRegionIcon } from '@/utils/helper'

const props = defineProps<{
    familiesForMap: FamiliesForMapType[]
    zone?: any
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

        // Initialize the draw control
        var drawControl = new L.Control.Draw({
            edit: {
                featureGroup: drawnItems,
                remove: true // Allow removing shapes
            },
            draw: {
                polygon: true, // Disable polygon drawing
                polyline: false, // Disable polyline drawing
                rectangle: true, // Disable rectangle drawing
                circle: true, // Disable circle drawing
                marker: false, // Disable marker drawing
                circlemarker: false // Disable circle marker drawing
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
            if (markerElem.location.lat && markerElem.location.lng) {
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
            }
        })

        // Initialize Leaflet Draw

        map.addLayer(drawnItems)

        if (props.zone) {
            L.geoJSON(props.zone, {
                onEachFeature: function (feature, layer) {
                    drawnItems.addLayer(layer)
                }
            }).addTo(drawnItems)

            disableDrawing()
        }

        var zoomControl = new L.Control.Zoom({
            zoomInTitle: 'Zoom In 2',
            zoomInText: '+',
            zoomOutTitle: 'Zoom Out 1',
            zoomOutText: '-',
            position: 'topleft'
        })

        L.drawLocal = {
            draw: {
                toolbar: {
                    actions: {
                        title: 'إلغاء الرسم',
                        text: 'إلغاء'
                    },
                    finish: {
                        title: 'إنهاء الرسم',
                        text: 'إنهاء'
                    },
                    undo: {
                        title: 'حذف آخر نقطة تم رسمها',
                        text: 'حذف آخر نقطة'
                    },
                    buttons: {
                        polyline: 'رسم خط متعدد النقاط',
                        polygon: 'رسم متعدد الأضلاع',
                        rectangle: 'رسم مستطيل',
                        circle: 'رسم دائرة',
                        marker: 'إضافة علامة',
                        circlemarker: 'رسم علامة دائرية'
                    }
                },
                handlers: {
                    circle: {
                        tooltip: {
                            start: 'انقر واسحب لرسم دائرة.'
                        },
                        radius: 'نصف القطر'
                    },
                    circlemarker: {
                        tooltip: {
                            start: 'انقر لوضع علامة دائرية.'
                        }
                    },
                    marker: {
                        tooltip: {
                            start: 'انقر لوضع علامة.'
                        }
                    },
                    polygon: {
                        tooltip: {
                            start: 'انقر لبدء رسم الشكل.',
                            cont: 'انقر لمواصلة رسم الشكل.',
                            end: 'انقر على النقطة الأولى لإغلاق هذا الشكل.'
                        }
                    },
                    polyline: {
                        error: '<strong>خطأ:</strong> لا يمكن أن تتقاطع حواف الشكل!',
                        tooltip: {
                            start: 'انقر لبدء رسم الخط.',
                            cont: 'انقر لمواصلة رسم الخط.',
                            end: 'انقر على آخر نقطة لإنهاء الخط.'
                        }
                    },
                    rectangle: {
                        tooltip: {
                            start: 'انقر واسحب لرسم مستطيل.'
                        }
                    },
                    simpleshape: {
                        tooltip: {
                            end: 'حرر الماوس لإنهاء الرسم.'
                        }
                    }
                }
            },
            edit: {
                toolbar: {
                    actions: {
                        save: {
                            title: 'حفظ التغييرات',
                            text: 'حفظ'
                        },
                        cancel: {
                            title: 'إلغاء التحرير، تجاهل جميع التغييرات',
                            text: 'إلغاء'
                        },
                        clearAll: {
                            title: 'مسح جميع الطبقات',
                            text: 'مسح الكل'
                        }
                    },
                    buttons: {
                        edit: 'تحرير الطبقات',
                        editDisabled: 'لا توجد طبقات للتحرير',
                        remove: 'حذف الطبقات',
                        removeDisabled: 'لا توجد طبقات للحذف'
                    }
                },
                handlers: {
                    edit: {
                        tooltip: {
                            text: 'اسحب المقابض أو العلامة لتحرير الميزة.',
                            subtext: 'انقر على إلغاء لإلغاء التغييرات.'
                        }
                    },
                    remove: {
                        tooltip: {
                            text: 'انقر على ميزة لإزالتها.'
                        }
                    }
                }
            }
        }

        L.tooltip({
            opacity: 1
        })

        // Add the custom zoom control to the map
        map.addControl(zoomControl)

        map.addLayer(drawnItems)

        map.addControl(drawControl)

        // Function to enable drawing

        // Event listener for when a shape is created
        map.on('draw:created', function (e) {
            let layer = e.layer

            drawnItems.addLayer(layer)

            // Disable the drawing tools after a shape is created
            disableDrawing()

            emit('set-zone', e.layer.toGeoJSON())
        })

        // Event listener for when a shape is deleted
        map.on('draw:deleted', function () {
            // Check if there are any layers left in the drawnItems
            if (drawnItems.getLayers().length === 0) {
                // Enable drawing if no shapes are left
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
    <leaflet-map-loader dir="ltr" :darkMode :init></leaflet-map-loader>
</template>
