import $ from 'jquery'

class Search {
    // 1. Describe and create/initiate our object
    constructor() {
        this.resultDiv = $('#search-overlay__results')
        this.openButton = $('.js-search-trigger')
        this.closeButton = $('.search-overlay__close')
        this.searchOverlay = $('.search-overlay')
        this.searchField = $("#search-term")
        this.events() // makes sure that the events get added to the web page as soon as it loads. !!!NB any variables that will be used in events MUST be above this line. searchField was bellow it and wouldn't work
        
        this.isOverlayOpen = false
        this.typingTimer
        this.isSpinnerVisible = false
        this.previousValue
        
    }

    // 2. events that trigger a response from the Class
    events() {
        this.openButton.on('click', this.openOverlay.bind(this))
        this.closeButton.on('click', this.closeOverlay.bind(this))
        $(document).on('keydown', this.keyPressDispatcher.bind(this))
        this.searchField.on('keyup', this.typingLogic.bind(this))
    }

    // 3. methods (functions & actions)
    keyPressDispatcher(e) {
        if(e.keyCode == 83  && !this.isOverlayOpen && !$('input, textarea').is(':focus')) { // IF we press S on our keyboard and the overlay isn't active, trigger the overlay show
            this.openOverlay()
        }

        if(e.keyCode == 27 && this.isOverlayOpen) { // IF we press Esc on our keyboard and the overlay is active, trigger the overlay hide
            this.closeOverlay()
        }
    }

    typingLogic() {
        if(this.searchField.val() != this.previousValue) {

            clearTimeout(this.typingTimer)
            if(this.searchField.val()) {
                if(!this.isSpinnerVisible) {
                    this.resultDiv.html('<div class="spinner-loader"></div>')
                    this.isSpinnerVisible = true
                }
                
                this.typingTimer = setTimeout( this.getResults.bind(this), 2000)
            } else {
                this.resultDiv.html('')
                this.isSpinnerVisible = false
            }

        }

        this.previousValue = this.searchField.val()
        
    }

    getResults() {
        $.getJSON(`${universityData.root_url}/wp-json/wp/v2/posts?search=${this.searchField.val()}`, function(data) {
            this.resultDiv.html(`
                <h2 class="search-overlay__section-title">General Info</h2>
                ${data.length ? '<ul class="link-list min-list">' : '<p>No matches</p>' }
                    ${data.map(item => `<li><a href="${item.link}">${item.title.rendered}</a></li>`).join('')}
                ${data.length ? '</ul>' : '' }
            `)
            this.isSpinnerVisible = false
        }.bind(this))
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