import BaseTippy from '../../../resources/js/Components/Base/tippy/BaseTippy.vue'

describe('<BaseTippy />', () => {
  it('renders', () => {
    // See: https://on.cypress.io/mounting-vue
    cy.mount(BaseTippy)
  })
})