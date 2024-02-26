import $ from 'jquery'

class MyNotes {
    constructor() {
        this.events()
    }

    events() {
        $('.delete-note').on('click', this.deleteNote)
    }

    // Custom Methods 
    deleteNote() {
        $.ajax({
            beforeSend: (xhr) => {
                xhr.setRequestHeader('X-WP-Nonce', universityData.nonce)
            },
            url: `${universityData.root_url}/wp-json/wp/v2/note/87`, // universityData from functions.php
            type: 'DELETE',
            success: (response) => {
                console.log('Congrats')
                console.log(response);
            }, // function we want to run if the request is successful 
            error: (response) => {
                console.log('Fail')
                console.log(response);
            },  // function we want to run if the request is fails 
        });
    }
}

export default MyNotes