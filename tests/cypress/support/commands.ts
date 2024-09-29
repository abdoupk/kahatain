/// <reference types="cypress" />
import '@cypress/code-coverage/support'
import './validation'

Cypress.Commands.add('fillCityFields', () => {
    Cypress.on('uncaught:exception', () => {
        return false
    })

    cy.intercept('/api/wilayas').then(() => {
        cy.get('#wilayas').select('32', { force: true })
    })

    cy.intercept('/api/dairas').then(() => {
        cy.get('[data-value="بوعلام"]').click()
    })

    cy.intercept('/api/communes').then(() => {
        cy.get('[data-value="1138"]').click()
    })
})

Cypress.Commands.add('clickNextOrRegisterButton', () => {
    cy.get('[data-test="next_or_register"]').click()
})

export {}
