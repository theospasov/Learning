<?php 
    get_header();

    while(have_posts()) { // while we still have posts
        the_post(); // keeps track of which post we're currently working with
        pageBanner();
        ?>

            <div class="container container--narrow page-section">
                <div class="metabox metabox--position-up metabox--with-home-link">
                    <p>
                    <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('campus'); ?>"><i class="fa fa-home" aria-hidden="true"></i> Back to All Campuses</a> <span class="metabox__main"><?php the_title() ?></span>
                    </p>
                </div>
                <div class="generic-content">

                <?php the_content(); ?>

                <?php
                    // Programs
                    $relatedPrograms = new WP_Query(array(
                        'posts_per_page' => -1, // -1 will display all posts, a positive number will display that many of the posts
                        'post_type' => 'program',
                        'orderby' => 'title', // default: post_date ; other option: title (desc alphabetically by title), rand (random), meta_value (meta data associated with the post), meta_value_num (meta data associated with the post that is numbers)
                        'order' => 'ASC', //default: DESC
                        'meta_query' => array(
                            array(
                                'key' => 'related_campuses',
                                'compare' => 'LIKE',//contains
                                'value' => '"' . get_the_ID() . '"', // the id will return a number, but that won't work with WP, because it expects a string. That's why we have to convert the number into string, we use concatenation with '.' symbol. From id 12 it becomes "12"
                            )
                        )
                        ));

                        if($relatedPrograms->have_posts()) {
                            echo '<hr class="section-break">';
                            echo '<h2 class="headline headline--medium">Programs Available at this campus</h2>';
                            echo '<ul class="min-list link-list">';
                            while($relatedPrograms->have_posts()) {
                            $relatedPrograms->the_post(); ?>
                                <li >
                                    <a href="<?php the_permalink(); ?>"><?php the_title( ) ?></a>
                                </li>
                            <?php }
                            echo '</ul>';
                            } wp_reset_postdata();
                ?>
                
                
            </div>
        </div>
    <?php 
    }

    get_footer();
?>

