<?php 
    get_header();

    while(have_posts()) { // while we still have posts
        the_post(); // keeps track of which post we're currently working with
        ?>
            <div class="page-banner">
                <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri( '/images/ocean.jpg' ) ?>)"></div>
                <div class="page-banner__content container container--narrow">
                    <h1 class="page-banner__title"><?php the_title( ) ?></h1>
                    <div class="page-banner__intro">
                    <p>TODO: Replace me later</p>
                    </div>
                </div>
            </div>

            <div class="container container--narrow page-section">
                <div class="metabox metabox--position-up metabox--with-home-link">
                    <p>
                    <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('program'); ?>"><i class="fa fa-home" aria-hidden="true"></i> Back to All Programs</a> <span class="metabox__main"><?php the_title() ?></span>
                    </p>
                </div>
                <div class="generic-content">

                <?php the_content(); ?>

                <?php
                    // Professors
                    $relatedProfessors = new WP_Query(array(
                        'posts_per_page' => -1, // -1 will display all posts, a positive number will display that many of the posts
                        'post_type' => 'professor',
                        'orderby' => 'title', // default: post_date ; other option: title (desc alphabetically by title), rand (random), meta_value (meta data associated with the post), meta_value_num (meta data associated with the post that is numbers)
                        'order' => 'ASC', //default: DESC
                        'meta_query' => array(
                            array(
                                'key' => 'related_programs',
                                'compare' => 'LIKE',//contains
                                'value' => '"' . get_the_ID() . '"', // the id will return a number, but that won't work with WP, because it expects a string. That's why we have to convert the number into string, we use concatenation with '.' symbol. From id 12 it becomes "12"
                            )
                        )
                        ));
    
                        if($relatedProfessors->have_posts()) {
                            echo '<hr class="section-break">';
                            echo '<h2 class="headline headline--medium"> ' . get_the_title() . ' Professors</h2>';
    
                            while($relatedProfessors->have_posts()) {
                            $relatedProfessors->the_post(); ?>
                                <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                            <?php }
                            } wp_reset_postdata();

                    // Events
                    $today = date('Ymd'); // format:20240204
                    $homepageEvents = new WP_Query(array(
                    'posts_per_page' => 2, // -1 will display all posts, a positive number will display that many of the posts
                    'post_type' => 'event',
                    'orderby' => 'meta_value_num', // default: post_date ; other option: title (desc alphabetically by title), rand (random), meta_value (meta data associated with the post), meta_value_num (meta data associated with the post that is numbers)
                    'meta_key' => 'event_date', // we tell meta_value_num which field/data to look at
                    'order' => 'ASC', //default: DESC
                    'meta_query' => array(
                        array(
                        'key' => 'event_date',
                        'compare' => '>=',
                        'value' => $today,
                        'type' => 'numeric' 
                        ), // we show events that are for today or in the future
                        array(
                            'key' => 'related_programs',
                            'compare' => 'LIKE',//contains
                            'value' => '"' . get_the_ID() . '"', // the id will return a number, but that won't work with WP, because it expects a string. That's why we have to convert the number into string, we use concatenation with '.' symbol. From id 12 it becomes "12"
                        )
                    )
                    ));

                    if($homepageEvents->have_posts()) {
                        echo '<hr class="section-break">';
                        echo '<h2 class="headline headline--medium">Upcoming ' . get_the_title() . ' Events</h2>';

                        while($homepageEvents->have_posts()) {
                        $homepageEvents->the_post(); ?>
                            <div class="event-summary">
                            <a class="event-summary__date t-center" href="<?php the_permalink(); ?>">
                                <span class="event-summary__month"><?php 
                                $eventDate = new DateTime(get_field('event_date')); // PHP Class. It will take data from the custom field event_data. We use get_field(), because the_field() echoes the data, we just want to return it
                                echo $eventDate->format('M')
                                ?></span>
                                <span class="event-summary__day"><?php echo $eventDate->format('d') ?></span>
                            </a>
                            <div class="event-summary__content">
                                <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink(); ?>"><?php the_title() ?></a></h5>
                                <p><?php if(has_excerpt()){
                                echo get_the_excerpt();
                                } else {
                                echo wp_trim_words(get_the_content(), 18 );
                                } ?><a href="<?php the_permalink(); ?>" class="nu gray">Learn more</a></p>
                            </div>
                            </div>
                        <?php }
                        }
                    wp_reset_postdata();
                ?>
                
            </div>
        </div>
    <?php 
    }

    get_footer();
?>

