import coverageTask from '@cypress/code-coverage/task'
import { defineConfig } from 'cypress'

export default defineConfig({
    e2e: {
        setupNodeEvents(on, config) {
            coverageTask(on, config)

            return config
        },
        specPattern: 'tests/cypress/e2e/**/*.{cy,spec}.{js,jsx,ts,tsx}',
        baseUrl: 'https://kafil.elyatim.test',
        supportFile: 'tests/cypress/support/e2e.{js,jsx,ts,tsx}',
        screenshotsFolder: 'tests/cypress/screenshots/e2e'
    },

    component: {
        devServer: {
            framework: 'vue',
            bundler: 'vite'
        },
        setupNodeEvents(on, config) {
            coverageTask(on, config)

            return config
        },
        indexHtmlFile: 'tests/cypress/support/component-index.html',
        specPattern: 'tests/cypress/component/**/*.{cy,spec}.{js,jsx,ts,tsx}',
        supportFile: 'tests/cypress/support/component.{js,jsx,ts,tsx}',
        screenshotsFolder: 'tests/cypress/screenshots/component'
    }
})
