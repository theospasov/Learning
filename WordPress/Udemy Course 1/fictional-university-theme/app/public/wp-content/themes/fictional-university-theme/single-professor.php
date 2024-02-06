<?php 
    get_header();

    while(have_posts()) { // while we still have posts
        the_post(); // keeps track of which post we're currently working with
        ?>
            <div class="page-banner">
                <div class="page-banner__bg-image" style="background-image: url(<?php $pageBannerImage = get_field('page_banner_image'); echo $pageBannerImage['sizes']['pageBanner'] ?>)"></div>
                <div class="page-banner__content container container--narrow">
                    <h1 class="page-banner__title"><?php the_title( ) ?></h1>
                    <div class="page-banner__intro">
                    <p><?php the_field('page_banner_subtitle') ?></p>
                    </div>
                </div>
            </div>

            <div class="container container--narrow page-section">
                <div class="generic-content">
                    <div class="row group">
                        <div class="one-third">
                            <?php the_post_thumbnail('professorPortrait'); ?>
                        </div>
                        <div class="two-thirds">
                            <?php the_content(); ?>
                        </div>
                    </div>
  
                </div>
                <?php 
                    $relatedPrograms = get_field('related_programs'); // with print_r($relatedPrograms) we can see that $relatedPrograms is an array that includes each related program and it's data
                    if($relatedPrograms) {
                        echo '<hr class="section-break">';
                        echo '<h2 class="headline headline--medium">Subjects Taught</h2>';
                        echo '<ul class="link-list min-list">';
                        foreach($relatedPrograms as $program) { ?>
                            <li><a href="<?php echo get_the_permalink($program); ?>"><?php echo get_the_title($program); ?></a></li>
                        <?php }
                        echo '</ul>'; 
                    }
            

                ?>
            </div>
                        
        <?php 
    }

    get_footer();
?>




