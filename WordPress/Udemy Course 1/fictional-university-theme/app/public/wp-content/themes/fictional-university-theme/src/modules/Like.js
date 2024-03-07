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


        if(currentLikeBox.attr('data-exists') == 'yes') {
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
                currentLikeBox.attr('data-exists', 'yes')
                let likeCount = parseInt(currentLikeBox.find('.like-count').html(), 10) // like count from string to number
                likeCount++
                currentLikeBox.find('.like-count').html(likeCount)
                currentLikeBox.attr('data-like', response)
                console.log(response);
            },
            error: (response) => {
                console.log(response);
            }
        })
    }

    deleteLike(currentLikeBox) {
        $.ajax({
            beforeSend: (xhr) => {
                xhr.setRequestHeader('X-WP-Nonce', universityData.nonce)
            },
            url: `${universityData.root_url}/wp-json/uni/v1/manageLike`,
            data: {'like': currentLikeBox.attr('data-like')},
            type: 'DELETE',
            success: (response) => {
                currentLikeBox.attr('data-exists', 'no')
                let likeCount = parseInt(currentLikeBox.find('.like-count').html(), 10) // like count from string to number
                likeCount--
                currentLikeBox.find('.like-count').html(likeCount)
                currentLikeBox.attr('data-like', '')
                console.log(response);
            },
            error: (response) => {
                console.log(response);
            }
        })
    }
}