import SvgLoader from '../../../resources/js/Components/SvgLoader.vue'

describe('<SvgLoader />', () => {
    it('renders', () => {
        cy.mount(SvgLoader, {
            props: {
                name: 'icon-bell'
            }
        })
    })
})
