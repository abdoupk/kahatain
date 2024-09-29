describe('Test for Step One', () => {
  beforeEach(() => {
    cy.visit('/register')
  })

  describe('should display error messages', () => {
    it('validate association and address fields', () => {
      cy.fillCityFields()

      cy.clickNextOrRegisterButton()

      cy.checkErrorMessage('address', 'The address field is required.')

      cy.checkErrorMessage('association', 'The association field is required.')
    })

    it('should display error message when domain field is empty', () => {
      cy.get('#association').type('association')

      cy.fillCityFields()

      cy.get('#address').type('address')

      cy.clickNextOrRegisterButton()

      cy.checkErrorMessage('domain', 'The domain field is required.')
    })

    it('should display error message when domain is already taken', () => {
      cy.fillField('association', 'association')

      cy.fillField('domain', 'foo')

      cy.fillField('address', 'address')

      cy.fillCityFields()

      cy.clickNextOrRegisterButton()

      cy.checkErrorMessage('domain', 'The domain has already been taken.')
    })
  })
})