import $ from 'jquery'

class MyNotes {
    constructor() {
        this.events()
    }

    events() {
        // Curr ver - this way we have a continues monitoring of the parent element my-notes, so we can implement CRUD on newly created notes, without having to refresh the page
        $('#my-notes').on('click', '.delete-note', this.deleteNote)
        $('#my-notes').on('click', '.edit-note',this.editNote.bind(this))
        $('#my-notes').on('click', '.update-note',this.updateNote.bind(this))
        $('.submit-note').on('click', this.createNote.bind(this))

        // //Prev ver - CRUD works with loaded notes, but not with newly created one
        // $('#delete-note').on('click', this.deleteNote)
        // $('.edit-note').on('click', this.editNote.bind(this))
        // $('.update-note').on('click', this.updateNote.bind(this))
        // $('.submit-note').on('click', this.createNote.bind(this))
    }

    // Custom Methods 

    // DELETE
        deleteNote(e) {
            let thisNote = $(e.target).parents('li') // selects the note that was clicked on

            $.ajax({
                beforeSend: (xhr) => {
                    xhr.setRequestHeader('X-WP-Nonce', universityData.nonce)
                },
                url: `${universityData.root_url}/wp-json/wp/v2/note/${thisNote.data('id')}`, // thisNote.data('id') will get us the <li data-id=''> number from the HTML
                type: 'DELETE',
                success: (response) => {
                    console.log('Congrats')
                    console.log(response);

                    // Visually hiding the note, so the user doesn't have to refresh the page to see the change 
                    thisNote.slideUp() // jQuery func that visually removes the element frm the page with a slideup animation (adds display: none)

                    if(response.userNoteCount < 5) {
                        $('.note-limit-message').removeClass('active')
                    }
                }, // function we want to run if the request is successful 
                error: (response) => {
                    console.log('Fail')
                    console.log(response);
                },  // function we want to run if the request is fails 
            });
        }
    //
    
    
    // EDIT

        editNote(e) {
            let thisNote = $(e.target).parents('li') // selects the note that was clicked on

            if(thisNote.data('state') == 'editable') {
                // make readonly
                this.makeNoteReadOnly(thisNote)

            } else {
                // make editable 
                this.makeNoteEditable(thisNote)
            }


        }


        updateNote(e) {
            let thisNote = $(e.target).parents('li') // selects the note that was clicked on
            let ourUpdatePost = {
                'title': thisNote.find('.note-title-field').val(),
                'content': thisNote.find('.note-body-field').val(),
            }

            $.ajax({
                beforeSend: (xhr) => {
                    xhr.setRequestHeader('X-WP-Nonce', universityData.nonce)
                },
                url: `${universityData.root_url}/wp-json/wp/v2/note/${thisNote.data('id')}`, // thisNote.data('id') will get us the <li data-id=''> number from the HTML
                type: 'POST',
                data: ourUpdatePost,
                success: (response) => {
                    console.log('Congrats')
                    console.log(response);

                    this.makeNoteReadOnly(thisNote)

                }, // function we want to run if the request is successful 
                error: (response) => {
                    console.log('Fail')
                    console.log(response);
                },  // function we want to run if the request is fails 
            });
        }


        makeNoteEditable(thisNote) {
            thisNote.find('.edit-note').html('<i class="fa fa-times" aria-hidden="true"></i> Cancel')
            thisNote.find('.note-title-field, .note-body-field').removeAttr('readonly').addClass('note-active-field')
            thisNote.find('.update-note').addClass('update-note--visible')
            thisNote.data('state', 'editable')
        }

        makeNoteReadOnly(thisNote) {
            thisNote.find('.edit-note').html('<i class="fa fa-pencil" aria-hidden="true"></i> Edit')
            thisNote.find('.note-title-field, .note-body-field').attr('readonly', 'readonly').removeClass('note-active-field')
            thisNote.find('.update-note').removeClass('update-note--visible')
            thisNote.data('state', 'non-editable')
        }
    //


    // CREATE
    createNote(e) {
        let ourNewPost = {
            'title': $('.new-note-title').val(),
            'content': $('.new-note-body').val(),
            'status': 'publish'//def - draft. By default crateNote will create a draft note and we won't see it on the frontend; We can choose 'public', so it appear for the user and in the default REST API or 'private' so it appears for the user, but not in the default REST API 
        }

        $.ajax({
            beforeSend: (xhr) => {
                xhr.setRequestHeader('X-WP-Nonce', universityData.nonce)
            },
            url: `${universityData.root_url}/wp-json/wp/v2/note/`,
            type: 'POST',
            data: ourNewPost,
            success: (response) => {
                $('.new-note-title, .new-note-body').val('')
                $(`
                    <li data-id="${response.id}">  <!--  We add the post id to the HTML, so we can use it in CRUD -->
                        <input readonly class="note-title-field" value="${response.title.raw}">  <!-- readonly - without the atr, when we open the My Notes page we can imminently edit the input and textarea, before even clicking on the Edit button, which is bad UI. When we set them to readonly we make it so users can't edit them upon page load; once they click on the Edit button, readonly will be removed and they can start editing their note -->
                        <span class="edit-note"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</span>
                        <span class="delete-note"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</span>
                        <textarea readonly class="note-body-field">${response.content.raw}</textarea>
                        <span class="update-note btn btn--blue btn--small"><i class="fa fa-arrow-right" aria-hidden="true"></i> Save</span>
                    </li>
                `).prependTo('#my-notes').hide().slideDown()

                console.log('Congrats')
                console.log(response);
  

                

            }, 
            error: (response) => {
                if(response.responseText == 'You have reached your note limit') {
                    $('.note-limit-message').addClass('active');
                }
                console.log('Fail')
                console.log(response);
            },  
        });
    }

    //

}

export default MyNotes