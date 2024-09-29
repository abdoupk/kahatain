Cypress.Commands.add('fillField', (fieldName: string, fieldValue: string) => {
    // eslint-disable-next-line cypress/unsafe-to-chain-command
    cy.get(`#${fieldName}`).focus().type(fieldValue)
})

Cypress.Commands.add('checkErrorMessage', (fieldName: string, errorMessage: string) => {
    cy.get(`[data-test='error_${fieldName}_message']`).should('contain', errorMessage)
})
