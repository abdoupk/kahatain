<template>
    <div>
        <div class="mx-auto mb-2 block text-center">
            <button :disabled="pageNum <= 1" @click="prevPage">Previous</button>

            <button :disabled="pageNum >= numPages" @click="nextPage">Next</button>

            <button @click="zoomIn">Zoom In</button>

            <button @click="zoomOut">Zoom Out</button>

            <span>Page {{ pageNum }} of {{ numPages }}</span>
        </div>

        <canvas ref="pdfCanvas" class="max-h-[calc(100vh-6rem)] border border-slate-300 dark:border-slate-600"></canvas>
    </div>
</template>

<script lang="ts" setup>
import * as pdfjsLib from 'pdfjs-dist'
import workerUrl from 'pdfjs-dist/build/pdf.worker.mjs?url'
import { onMounted, ref } from 'vue'

const props = defineProps<{
    pdfUrl: string
}>()

pdfjsLib.GlobalWorkerOptions.workerSrc = workerUrl

// Define refs for the canvas and pagination
const pdfCanvas = ref<HTMLCanvasElement | null>(null)

const pageNum = ref(1)

const numPages = ref(0)

const zoomLevel = ref(1)

let pdf: pdfjsLib.PDFDocumentProxy | null = null // Use the correct type for pdf

// Load the PDF document
const loadPdf = async (url: string) => {
    try {
        const loadingTask = pdfjsLib.getDocument({
            url: url,
            disableFontFace: true
        })

        pdf = await loadingTask.promise

        numPages.value = pdf.numPages

        await renderPage(pageNum.value)
    } catch (error) {
        // eslint-disable-next-line no-console
        console.error(error)
    }
}

// Render a specific page
const renderPage = async (num: number, zoom = 1) => {
    if (!pdf || !pdfCanvas.value) return

    try {
        const page = await pdf.getPage(num)

        const viewport = page.getViewport({ scale: zoom }) // Adjust scale as needed

        const context = pdfCanvas.value.getContext('2d')

        pdfCanvas.value.height = viewport.height

        pdfCanvas.value.width = viewport.width

        const renderContext = {
            canvasContext: context,
            viewport: viewport
        }

        await page.render(renderContext).promise
    } catch (error) {
        // eslint-disable-next-line no-console
        console.error(error)
    }
}

// Navigation methods
const nextPage = () => {
    if (pageNum.value < numPages.value) {
        pageNum.value++

        renderPage(pageNum.value)
    }
}

const prevPage = () => {
    if (pageNum.value > 1) {
        pageNum.value--

        renderPage(pageNum.value)
    }
}

const zoomIn = () => {
    zoomLevel.value += 0.1

    renderPage(pageNum.value, zoomLevel.value)
}

const zoomOut = () => {
    zoomLevel.value -= 0.1

    renderPage(pageNum.value, zoomLevel.value)
}

// Load the PDF when the component is mounted
onMounted(() => {
    loadPdf(props.pdfUrl) // Update with your PDF path
})
</script>

<style scoped>
canvas {
    width: 100%;
}
</style>
