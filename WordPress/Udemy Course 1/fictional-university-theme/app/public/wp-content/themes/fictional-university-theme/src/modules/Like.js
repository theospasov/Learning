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
            this.deleteLike(currentLikeBox)
        } else {
            this.crateLike(currentLikeBox)
        }
    }

    crateLike(currentLikeBox) {
        $.ajax({
            beforeSend: (xhr) => {
                xhr.setRequestHeader('X-WP-Nonce', universityData.nonce)
            },
            url: `${universityData.root_url}/wp-json/uni/v1/manageLike`, 
            type: 'POST',
            data: {'professorId' : currentLikeBox.data('professor') }, // equivalent of /wp-json/uni/v1/manageLike?professorId='x'
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