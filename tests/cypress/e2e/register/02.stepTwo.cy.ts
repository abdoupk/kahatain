describe('Test for Step Two', () => {
    beforeEach(() => {
        cy.visit('/register')

        cy.get('#association').type('association')

        cy.get('#domain').type('baz')

        cy.fillCityFields()

        cy.get('#address').type('address')

        cy.clickNextOrRegisterButton()
    })

    it('should navigate to Step Two', () => {
        cy.get('#first_name').should('exist')
    })

    describe('show validation errors', () => {
        it('should display error messages when all fields are empty', () => {
            cy.clickNextOrRegisterButton()

            cy.checkErrorMessage('first_name', 'The first name field is required.')

            cy.checkErrorMessage('last_name', 'The last name field is required.')

            cy.checkErrorMessage('email', 'The email field is required.')

            cy.checkErrorMessage('phone', 'The phone field is required.')

            cy.checkErrorMessage('password', 'The password field is required.')
        })

        describe('validate password, email and phone', () => {
            it('should validate email field when it\'s not valid', () => {
                cy.fillField('email', 'email')

                cy.clickNextOrRegisterButton()

                cy.checkErrorMessage('email', 'The email must be a valid email address.')
            })

            it('should display error when email is already taken', () => {
                cy.fillField('email', 'test@example.com')

                cy.clickNextOrRegisterButton()

                cy.checkErrorMessage('email', 'The email has already been taken.')
            })

            it('should be prevent to type strings in phone field', () => {
                cy.fillField('phone', 'no valid phone number')

                cy.clickNextOrRegisterButton()

                cy.checkErrorMessage('phone', 'The phone field is required.')
            })

            it('should display error when phone number is not valid', () => {
                cy.fillField('phone', '066495481')

                cy.clickNextOrRegisterButton()

                cy.checkErrorMessage('phone', 'The phone format is invalid.')
            })

            it('should display error when password not confirmed', () => {
                cy.fillField('password', 'password')

                cy.clickNextOrRegisterButton()

                cy.checkErrorMessage('password', 'The password confirmation does not match.')
            })

            it('should display error message when password is invalid', () => {

                cy.fillField('password_confirmation', 'p')

                cy.fillField('password', 'p')

                cy.clickNextOrRegisterButton()

                cy.checkErrorMessage('password', 'The password must be at least 8 characters.')
            })

            it('should not display any error message when all field does validated', () => {
                const fieldValidations = [
                    { field: 'phone', inputValue: '0600000000' },
                    { field: 'email', inputValue: 'validemail@example.com' },
                    { field: 'password', inputValue: 'password' },
                    { field: 'password_confirmation', inputValue: 'password' },
                    { field: 'first_name', inputValue: 'first name' },
                    { field: 'last_name', inputValue: 'last name' }
                ]

                fieldValidations.forEach(validation => {
                    cy.fillField(validation.field, validation.inputValue)
                })

                cy.clickNextOrRegisterButton()

                fieldValidations.forEach(validation => {
                    cy.get(`[data-test="error_${validation.field}_message"]`).should('not.exist')
                })
            })
        })
    })
})
