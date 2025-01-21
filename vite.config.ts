import vue from '@vitejs/plugin-vue'
import laravel from 'laravel-vite-plugin'
import i18n from 'laravel-vue-i18n/vite'
import path from 'path'
import { visualizer } from 'rollup-plugin-visualizer'
import { defineConfig } from 'vite'
import istanbul from 'vite-plugin-istanbul'
import svgLoader from 'vite-svg-loader'

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.ts'],
            ssr: 'resources/js/ssr.ts',
            refresh: true,
            buildDirectory: 'build/dashboard',
            ssrOutputDirectory: 'bootstrap/ssr/dashboard'
        }),
        vue({
            script: {
                defineModel: true,
                propsDestructure: true
            },
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false
                },
                compilerOptions: {
                    nodeTransforms: process.env.NODE_ENV === 'production' ? [removeDataTest] : []
                }
            }
        }),
        i18n(),
        istanbul({
            include: ['resources/js/*'], // List of all directories/files you want to track coverage for
            exclude: ['node_modules'], // List of all directories/files you do not want to track coverage for
            extension: ['.js', '.ts', '.vue'], // List of all file extensions you would like to track coverage for
            requireEnv: false // If set to true, more config is needed
        }),
        svgLoader(),
        visualizer()
    ],
    build: {
        commonjsOptions: {
            include: ['node_modules/**']
        },
        rollupOptions: {
            output: {
                entryFileNames: `[name].js`,
                chunkFileNames: `assets/[hash].js`,
                assetFileNames: `assets/[hash][extname]`
            }
        },
        ssrManifest: true,
        sourcemap: true,
        minify: 'esbuild'
    },
    resolve: {
        alias: {
            // eslint-disable-next-line no-undef
            'ziggy-js': path.resolve(__dirname, './vendor/tightenco/ziggy')
        }
    }
})

function removeDataTest(node: any) {
    if (node.type === 1 /* NodeTypes.ELEMENT */) {
        node.props = node.props.filter((prop: any) => (prop.type === 6 ? prop.name !== 'data-test' : true))
    }
}
