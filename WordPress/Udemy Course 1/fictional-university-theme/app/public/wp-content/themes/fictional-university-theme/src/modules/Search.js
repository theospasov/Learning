import $ from 'jquery'

class Search {
    // 1. Describe and create/initiate our object
    constructor() {
        this.openButton = $('.js-search-trigger')
        this.closeButton = $('.search-overlay__close')
        this.searchOverlay = $('.search-overlay')
        this.events() // makes sure that the events get added to the web page as soon as it loads.
        this.isOverlayOpen = false
    }

    // 2. events that trigger a response from the Class
    events() {
        this.openButton.on('click', this.openOverlay.bind(this))
        this.closeButton.on('click', this.closeOverlay.bind(this))
        $(document).on('keydown', this.keyPressDispatcher.bind(this))
    }

    // 3. methods (functions & actions)
    keyPressDispatcher(e) {
        
        if(e.keyCode == 83  && !this.isOverlayOpen) { // IF we press S on our keyboard and the overlay isn't active, trigger the overlay show
            this.openOverlay()
            
        }

        if(e.keyCode == 27 && this.isOverlayOpen) { // IF we press Esc on our keyboard and the overlay is active, trigger the overlay hide
            this.closeOverlay()
        }
    }

    openOverlay() {
        this.searchOverlay.addClass('search-overlay--active')
        $('body').addClass('body-no-scroll')
        this.isOverlayOpen = true

    }

    closeOverlay() {
        this.searchOverlay.removeClass('search-overlay--active')
        $('body').removeClass('body-no-scroll')
        this.isOverlayOpen = false
    }
}

export default Search