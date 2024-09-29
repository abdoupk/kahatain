import './commands'
import { createPinia } from 'pinia'
import { mount } from 'cypress/vue'

Cypress.Commands.add('mount', (component, options = {}) => {
    options.global = options.global || {}

    options.global.plugins = options.global.plugins || []

    options.global.plugins.push(createPinia())

    return mount(component, options)
})
