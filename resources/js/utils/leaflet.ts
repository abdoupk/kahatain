import { useSettingsStore } from '@/stores/settings'
import { computed } from 'vue'

import { extractColor } from '@/utils/colors'
import { getMarkerIcon, getMarkerRegionIcon } from '@/utils/helper'

export const drawLocal = {
    ar: {
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
                    polygon: 'تحديد المنطقة',
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
}

export const setMapMarkers = (leaflet, markers, positions) => {
    const darkMode = computed(() => useSettingsStore().appearance === 'dark')

    const colorScheme = computed(() => useSettingsStore().colorScheme)

    const color = darkMode.value && colorScheme.value ? extractColor('darkmode-100') : extractColor('primary')

    const mapMarkerSvg = getMarkerIcon(color)

    positions.map(function (markerElem) {
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
}

export const getMarkers = (leaflet) => {
    const darkMode = computed(() => useSettingsStore().appearance === 'dark')

    const colorScheme = computed(() => useSettingsStore().colorScheme)

    return leaflet.markerClusterGroup({
        maxClusterRadius: 30,
        iconCreateFunction: function (cluster) {
            const color =
                darkMode.value && colorScheme.value ? extractColor('darkmode-100', 0.6) : extractColor('primary', 0.8)

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
}
