describe('Tests for Step Three', () => {
    beforeEach(() => {
        cy.visit('/register')

        cy.get('#association').type('association')

        cy.get('#domain').type('baz')

        cy.fillCityFields()

        cy.get('#address').type('address')

        cy.clickNextOrRegisterButton()

        cy.get('#first_name').type('chikh')

        cy.get('#last_name').type('rezig')

        cy.get('#phone').type('0664954810')

        // eslint-disable-next-line cypress/unsafe-to-chain-command
        cy.get('#email').focus().type('validemail@example.com')

        // eslint-disable-next-line cypress/unsafe-to-chain-command
        cy.get('#password').focus().type('password')

        // eslint-disable-next-line cypress/unsafe-to-chain-command
        cy.get('#password_confirmation').focus().type('password')

        cy.clickNextOrRegisterButton()

        cy.clickNextOrRegisterButton()
    })

    it('should navigate to Step Three', () => {
        cy.get('#association_email').should('exist')
    })

    it('should show error message when all fields not touched', () => {
        cy.clickNextOrRegisterButton()

        cy.checkErrorMessage('association_email', 'The association email must be a valid email address.')

        cy.checkErrorMessage('phones_0', 'The phones.0 field is required.')
    })

    describe('validate landline field', () => {
        it('should prevent user to type chars in the field', () => {
            cy.get('#landline').should('be.visible')

            cy.get('#landline').type('invalid')

            cy.clickNextOrRegisterButton()

            cy.get('[data-test="error_landline_message"]').should('not.exist')
        })

        it('should display error message when the landline is invalid', () => {
            cy.get('#landline').should('be.visible')

            cy.get('#landline').type('953423')

            cy.clickNextOrRegisterButton()

            cy.checkErrorMessage('landline', 'The landline format is invalid.')
        })

        it('should not display any error message related with landline when it\'s valid', () => {
            cy.get('#landline').should('be.visible')

            cy.get('#landline').type('049675528')

            cy.clickNextOrRegisterButton()

            cy.get('[data-test="error_landline_message"]').should('not.exist')
        })
    })

    describe('validate phone number', () => {
        it('should prevent user to type chars for the field', () => {
            cy.get('#phones_0').should('be.visible')

            cy.clickNextOrRegisterButton()

            cy.get('[data-test="error_phones_0_message"]').should('not.exist')
        })

        it('should display error message when the phone is invalid', () => {
            cy.get('#phones_0').type('066495481')

            cy.clickNextOrRegisterButton()

            cy.checkErrorMessage('phones_0', 'The phones.0 format is invalid.')
        })

        it('should display error message when phone is already taken', () => {
            cy.get('#phones_0').type('0664954817')

            cy.clickNextOrRegisterButton()

            cy.get('[data-test="error_phones_0_message"]').should('not.exist')
        })

        it('should add new phone when click to add new phone button ', () => {
            cy.get('[data-test="add_phone_number"]').click()

            cy.get('#phones_1').should('exist')
        })
    })

    describe('validate social media links', () => {
        it('should display error message when the facebook link is invalid', () => {
            cy.get('#facebook').type('facebook.com')

            cy.clickNextOrRegisterButton()

            cy.checkErrorMessage('links_facebook', 'The links.facebook format is invalid.')
        })

        it('should display error message when the instagram link is invalid', () => {
            cy.get('#instagram').type('facebook.com')

            cy.clickNextOrRegisterButton()

            cy.checkErrorMessage('links_instagram', 'The links.instagram format is invalid.')
        })
    })

    describe('Registration successful', () => {
        it('should be register new association and redirect to login path', () => {

            cy.fillField('phones_0', '0664954817')

            cy.fillField('association_email', 'valid_ass@email.com')

            cy.fillField('landline', '049675528')

            cy.clickNextOrRegisterButton()

            cy.get('[data-test="successNotification"]').should('exist')

            // eslint-disable-next-line cypress/no-unnecessary-waiting
            cy.wait(5000)

            cy.url().should('eq', 'https://baz.kafil.elyatim.test/login')
        })
    })
})
