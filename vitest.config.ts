import {defineConfig, mergeConfig} from 'vite'
import {configDefaults} from 'vitest/config'
import {fileURLToPath} from 'node:url'
import viteConfig from './vite.config'

export default mergeConfig(
    viteConfig,
    defineConfig({
        test: {
            environment: 'jsdom',
            exclude: [...configDefaults.exclude, 'e2e/*'],
            root: fileURLToPath(new URL('./', import.meta.url)),
            testTransformMode: {
                web: ['/\.[jt]sx$/']
            }
        }
    })
)
