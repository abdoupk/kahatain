import MobileMenuLink from '../../../resources/js/Components/mobile-menu/MobileMenuLink.vue'

describe('<MobileMenuLink />', () => {
    it('renders', () => {
        cy.mount(MobileMenuLink, {
            props: {
                level: 'first',
                menu: {
                    url: 'title',
                    submenu: null
                }
            }
        })
    })
})
