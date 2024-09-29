import AppearanceSelector from '../../../resources/js/Components/theme-switcher/AppearanceSelector.vue'

describe('<AppearanceSelector />', () => {
  it('renders', () => {
    // See: https://on.cypress.io/mounting-vue
    cy.mount(AppearanceSelector)
  })
})