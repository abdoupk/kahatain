import SvgLoader from '../../../resources/js/Components/Global/SvgLoader.vue'

describe('<SvgLoader />', () => {
    it('renders', () => {
        cy.mount(SvgLoader, {
            props: {
                name: 'icon-bell'
            }
        })
    })
})
