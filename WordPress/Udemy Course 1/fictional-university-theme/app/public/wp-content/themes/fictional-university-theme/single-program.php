<?php 
    get_header();

    while(have_posts()) { // while we still have posts
        the_post(); // keeps track of which post we're currently working with
        pageBanner();
        ?>

            <div class="container container--narrow page-section">
                <div class="metabox metabox--position-up metabox--with-home-link">
                    <p>
                    <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('program'); ?>"><i class="fa fa-home" aria-hidden="true"></i> Back to All Programs</a> <span class="metabox__main"><?php the_title() ?></span>
                    </p>
                </div>
                <div class="generic-content">

                <?php the_field('programs_alternative_body_content'); ?>

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
                            echo '<ul class="professor-cards">';
                            while($relatedProfessors->have_posts()) {
                            $relatedProfessors->the_post(); ?>
                                <li class="professor-card__list-item">

                                    <a class="professor-card" href="<?php the_permalink(); ?>">
                                        <img class="professor-card__image" src="<?php the_post_thumbnail_url('professorLandscape') ?>"  >
                                        <span class="professor-card__name"><?php the_title() ?></span>
                                    </a>
                                </li>
                            <?php }
                            echo '</ul>';
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
                        $homepageEvents->the_post();
                        get_template_part('template-parts/content-event');
                        }
                    }

                    wp_reset_postdata();


                    // Campuses
                    $relatedCampuses = get_field('related_campuses');
                    if($relatedCampuses) {
                        echo '<hr class="section-break"></hr>';
                        echo '<h2 class="headline headline--medium">' . get_the_title( ). ' is Available at these campuses</h2>';
                        
                        echo '<ul class="min-list link-list">';
                        foreach($relatedCampuses as $campus) {
                            ?>
                            <li><a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title($campus); ?></a></li>
                            <?php
                        }
                        echo '</ul>';
                    }
                ?>
                
            </div>
        </div>
    <?php 
    }

    get_footer();
?>

