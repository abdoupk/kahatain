import { CyEventEmitter } from 'cypress/types/cypress-eventemitter'
import { mount } from 'cypress/vue'

declare global {
    namespace Cypress {
        interface Chainable {
            fillCityFields(): Chainable

            clickNextOrRegisterButton(): CyEventEmitter

            fillField(fieldName: string, fieldValue: string): Chainable

            checkErrorMessage(fieldName: string, errorMessage: string): Chainable

            mount: typeof mount
        }
    }
}
