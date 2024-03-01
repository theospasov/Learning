import $ from 'jquery'

export default class Like {
    constructor() {
        this.events()
    }

    events() {
        $('.like-box').on('click', this.clickDispatcher.bind(this))
    }

    // methods
    clickDispatcher(e) {
        // in case we have multiple like boxes
        let currentLikeBox = $(e.target).closest('.like-box')


        if(currentLikeBox.data('exists') == 'yes') {
            this.deleteLike()
        } else {
            this.crateLike()
        }
    }

    crateLike() {
        $.ajax({
            url: `${universityData.root_url}/wp-json/uni/v1/manageLike`, 
            type: 'POST',
            success: (response) => {
                console.log(response);
            },
            error: (response) => {
                console.log(response);
            }
        })
    }

    deleteLike() {
        $.ajax({
            url: `${universityData.root_url}/wp-json/uni/v1/manageLike`, 
            type: 'DELETE',
            success: (response) => {
                console.log(response);
            },
            error: (response) => {
                console.log(response);
            }
        })
    }
}