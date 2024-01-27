<?php 
    get_header();

    while(have_posts()) { // while we still have posts
        the_post(); // keeps track of which post we're currently working with
        ?>
        <h1>This is a page not a post</h1>
        <h2><?php the_title() ?></h2>
        <?php the_content( ) ?>
        <?php 
    }

    get_footer();
?>