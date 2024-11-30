<script lang="ts" setup>
import PhotoSwipeLightbox from 'photoswipe/lightbox'
import 'photoswipe/style.css'
import { onMounted, onUnmounted } from 'vue'

interface Image {
    original: string
    width: number
    height: number
    thumb: string
}

const props = defineProps<{
    galleryId: string
    images: Image[]
}>()

let lightbox: PhotoSwipeLightbox | null = null

onMounted(() => {
    lightbox = new PhotoSwipeLightbox({
        gallery: `#${props.galleryId}`,
        children: 'a',
        pswpModule: () => import('photoswipe')
    })

    lightbox.init()
})

onUnmounted(() => {
    if (lightbox) {
        lightbox.destroy()

        lightbox = null
    }
})
</script>

<template>
    <div :id="galleryId" class="grid grid-cols-2 gap-2 md:grid-cols-3 md:gap-0">
        <a
            v-for="(image, key) in images"
            :key="key"
            :data-pswp-height="image.height"
            :data-pswp-width="image.width"
            :href="image.original"
            rel="noreferrer"
            target="_blank"
        >
            <img :src="image.thumb" alt="" class="h-48 max-w-full" />
        </a>
    </div>
</template>
