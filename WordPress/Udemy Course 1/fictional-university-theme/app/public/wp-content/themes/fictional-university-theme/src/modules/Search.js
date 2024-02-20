import $ from 'jquery'

class Search {
    // 1. Describe and create/initiate our object
    constructor() {
        this.addSearchHTML()
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
                
                this.typingTimer = setTimeout( this.getResults.bind(this), 750)
            } else {
                this.resultDiv.html('')
                this.isSpinnerVisible = false
            }

        }

        this.previousValue = this.searchField.val()
        
    }

    getResults() {
        //Asynchronous Version
        // jQuery when() method - all of the JSON request will run asynchronously 
        $.when(
            $.getJSON(`${universityData.root_url}/wp-jsondd/wp/v2/posts?search=${this.searchField.val()}`),
            $.getJSON(`${universityData.root_url}/wp-json/wp/v2/pages?search=${this.searchField.val()}`),

        ).then((resultPosts, resultPages) => { // then() collects the results from when() and allows us to use them. The 1st arg is a function that can use the results and the 2nd arg is Error Handling - what will happen when we unsuccessful request in the when()
            let combinedResult = resultPosts[0].concat(resultPages[0]) // then() returns an array, where the 1st arg is the result, the second is whether the request was successful 
                console.log(resultPages);
                this.resultDiv.html(`
                <h2 class="search-overlay__section-title">General Info</h2>
                ${combinedResult.length ? '<ul class="link-list min-list">' : '<p>No matches</p>' }
                    ${combinedResult.map(item => `<li><a href="${item.link}">${item.title.rendered}</a></li>`).join('')}
                ${combinedResult.length ? '</ul>' : '' }
            `)
            this.isSpinnerVisible = false
        }, () => {
            //Error Handling
            this.resultDiv.html(`<p>Unexpected error</p>`)
        })


        //Synchronous Version
            // $.getJSON(`${universityData.root_url}/wp-json/wp/v2/posts?search=${this.searchField.val()}`, resultPosts => 
            // {
            //     $.getJSON(`${universityData.root_url}/wp-json/wp/v2/pages?search=${this.searchField.val()}`, resultPages => 
            //     {
            //         let combinedResult = resultPosts.concat(resultPages)
            //         this.resultDiv.html(`
            //         <h2 class="search-overlay__section-title">General Info</h2>
            //         ${combinedResult.length ? '<ul class="link-list min-list">' : '<p>No matches</p>' }
            //             ${combinedResult.map(item => `<li><a href="${item.link}">${item.title.rendered}</a></li>`).join('')}
            //         ${combinedResult.length ? '</ul>' : '' }
            //     `)
            //     this.isSpinnerVisible = false
            //     })
            // })
        
    }

    openOverlay() {
        this.searchOverlay.addClass('search-overlay--active')
        $('body').addClass('body-no-scroll')
        this.searchField.val('')
        setTimeout(() => this.searchField.trigger('focus'), 301)
        this.isOverlayOpen = true
    }

    closeOverlay() {
        this.searchOverlay.removeClass('search-overlay--active')
        $('body').removeClass('body-no-scroll')
        this.isOverlayOpen = false
    }

    addSearchHTML() {
        $('body').append(`
            <div class="search-overlay">
                <div class="search-overlay__top">
                <div class="container">
                    <i class="fa fa-search search-overlay__icon" area-hidden="true"></i>
                    <input type="text" class="search-term" placeholder="Search me" id="search-term" autocomplete="off" >
                    <i class="fa fa-window-close search-overlay__close" area-hidden="true"></i>
                </div>
                </div>
        
                <div class="container">
                <div id="search-overlay__results"></div>
                </div>
            </div>
        `)
    }
}

export default Search