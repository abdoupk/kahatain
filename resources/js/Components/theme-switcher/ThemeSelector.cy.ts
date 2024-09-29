import ThemeSelector from './ThemeSelector.vue'

describe('<ThemeSelector />', () => {
    it('renders', () => {
        // See: https://on.cypress.io/mounting-vue
        cy.mount(ThemeSelector)
    })
})
