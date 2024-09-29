// eslint-ignore
import laravel from 'laravel-vite-plugin'
import { defineConfig } from 'vite'

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/landing.ts',
            refresh: true
        })
    ],
    build: {
        ssr: false,
        rollupOptions: {
            output: {
                entryFileNames: `[name].js`,
                chunkFileNames: `assets/[hash].js`,
                assetFileNames: `assets/[hash][extname]`
            }
        },
        minify: 'esbuild'
    }
})
