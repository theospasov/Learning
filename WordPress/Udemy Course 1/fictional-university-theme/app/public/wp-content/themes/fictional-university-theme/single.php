<?php 
    get_header();

    while(have_posts()) { // while we still have posts
        the_post(); // keeps track of which post we're currently working with
        pageBanner(); 
        ?>

            <div class="container container--narrow page-section">
                <div class="metabox metabox--position-up metabox--with-home-link">
                    <p>
                    <a class="metabox__blog-home-link" href="<?php echo site_url('/blog') ?>"><i class="fa fa-home" aria-hidden="true"></i> Back to Blog</a> <span class="metabox__main">Posted by <?php the_author_posts_link() ?> on <?php the_time('d M Y') ?> in <?php echo get_the_category_list(', ' ) ?></p></span>
                    </p>
                </div>
                <div class="generic-content">
                    <?php the_content(); ?>
                </div>
            </div>
        <?php 
    }

    get_footer();
?>
