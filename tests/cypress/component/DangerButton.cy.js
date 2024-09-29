import DangerButton from '../../../resources/js/Components/DangerButton.vue'

describe('<DangerButton />', () => {
  it('renders', () => {
    // See: https://on.cypress.io/mounting-vue
    cy.mount(DangerButton)
  })
})