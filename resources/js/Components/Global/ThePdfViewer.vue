<template>
    <div>
        <canvas ref="pdfCanvas"></canvas>
        <div>
            <button @click="prevPage" :disabled="pageNum <= 1">Previous</button>
            <button @click="nextPage" :disabled="pageNum >= numPages">Next</button>
            <span>Page {{ pageNum }} of {{ numPages }}</span>
        </div>
    </div>
</template>

<script setup lang="ts">
import * as pdfjsLib from 'pdfjs-dist'
import workerUrl from 'pdfjs-dist/build/pdf.worker.mjs?url'
import { onMounted, ref } from 'vue'

pdfjsLib.GlobalWorkerOptions.workerSrc = workerUrl

// Define refs for the canvas and pagination
const pdfCanvas = ref<HTMLCanvasElement | null>(null)

const pageNum = ref(1)

const numPages = ref(0)

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
const renderPage = async (num: number) => {
    if (!pdf || !pdfCanvas.value) return

    try {
        const page = await pdf.getPage(num)

        const viewport = page.getViewport({ scale: 1 }) // Adjust scale as needed

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

// Load the PDF when the component is mounted
onMounted(() => {
    loadPdf('https://mozilla.github.io/pdf.js/web/compressed.tracemonkey-pldi-09.pdf') // Update with your PDF path
})
</script>

<style scoped>
canvas {
    border: 1px solid black;
    width: 100%;
}
</style>
