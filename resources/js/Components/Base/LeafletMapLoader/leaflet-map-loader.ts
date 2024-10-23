import L, { Map, MapOptions } from 'leaflet'
import { GestureHandling } from 'leaflet-gesture-handling'
import 'leaflet.markercluster'

export interface MapConfig {
    config: MapOptions
}

export interface LeafletElement extends HTMLDivElement {
    map: Map
}

const initializeMap = async (mapRef: LeafletElement, mapConfig: MapConfig) => {
    if (mapRef.map) {
        mapRef.map.remove()
    }

    const map = L.map(mapRef, mapConfig.config)

    L.Map.addInitHook('addHandler', 'gestureHandling', GestureHandling)

    mapRef.map = map

    return {
        map: map,
        leaflet: L
    }
}

export { initializeMap }
