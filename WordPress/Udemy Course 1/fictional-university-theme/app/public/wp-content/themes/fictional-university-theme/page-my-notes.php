<?php 

    if (!is_user_logged_in(  )) {
        wp_redirect(esc_url(site_url('/')));
        exit; 
    }

    get_header();

    while(have_posts()) { // while we still have posts
        the_post(); // keeps track of which post we're currently working with
        pageBanner();

        ?>

            <div class="container container--narrow page-section">

                <div class="create-note">
                    <h2 class="headline headline--medium">Create New Note</h2>
                    <input class="new-note-title" placeholder="Title">
                    <textarea class="new-note-body" placeholder="Type your note" ></textarea>
                    <span class="submit-note">Create Note</span>
                </div>
                <ul class="min-list link-list" id="my-notes">
                    <?php 
                        $userNotes = new WP_Query(array(
                            'post_type' => 'note',
                            'posts_per_page' => -1,
                            'author' => get_current_user_id(), // this ensures we ONLY get the notes of the logged in user
                        ));

                        while ($userNotes->have_posts()) {
                            $userNotes->the_post();
                            ?>
                                <li data-id="<?php the_ID(); ?>">  <!--  We add the post id to the HTML, so we can use it in CRUD -->
                                    <input readonly class="note-title-field" value="<?php echo esc_attr(wp_strip_all_tags(get_the_title())); ?>">  <!-- readonly - without the atr, when we open the My Notes page we can imminently edit the input and textarea, before even clicking on the Edit button, which is bad UI. When we set them to readonly we make it so users can't edit them upon page load; once they click on the Edit button, readonly will be removed and they can start editing their note -->
                                    <span class="edit-note"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</span>
                                    <span class="delete-note"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</span>
                                    <textarea readonly class="note-body-field"><?php echo esc_attr(wp_strip_all_tags(get_the_content())); ?></textarea>
                                    <span class="update-note btn btn--blue btn--small"><i class="fa fa-arrow-right" aria-hidden="true"></i> Save</span>
                                </li>
                            <?php
                        }
                    ?>
                </ul>              
            </div>


        <?php 
    }

    get_footer();
?>