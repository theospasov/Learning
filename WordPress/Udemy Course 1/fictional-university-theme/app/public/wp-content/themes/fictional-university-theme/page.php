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
                <!-- We check if the page has a parent page and if so, we visualize a box with the title of the child page and link back to it's parent. -->
                <?php 
                    $parentPostId = wp_get_post_parent_id();
                    if($parentPostId) { 
                    ?>
                        
                        <div class="metabox metabox--position-up metabox--with-home-link">
                            <p>
                            <a class="metabox__blog-home-link" href="<?php echo get_permalink($parentPostId); ?>"><i class="fa fa-home" aria-hidden="true"></i> Back to <?php echo get_the_title($parentPostId); ?></a> <span class="metabox__main"><?php the_title( ) ?></span>
                            </p>
                        </div>
                    <?php
                        
                    }
                ?>


            <?php
            $testArray = get_pages(array(
                'child_of' => get_the_ID()
            ));

            if($parentPostId or $testArray) { ?>
            <div class="page-links">
                <h2 class="page-links__title"><a href="<?php echo get_permalink($parentPostId) ?>"><?php echo get_the_title($parentPostId); ?></a></h2>
                <ul class="min-list">
                    <?php 
                        if($parentPostId) { // Only if the current page has a parent page
                            $findChildrenOf = $parentPostId;
                        } else {
                            $findChildrenOf = get_the_ID();
                        }
                        wp_list_pages(array(
                            'title_li' => NULL, //removes the title of the list
                            'child_of' => $findChildrenOf, //use children of the parent 
                            'sort_column' => 'menu_order' //sort child pages by order (Post/Page Edit-> Document Tab -> Order )
                        )); 
                    ?>
                <!-- <li class="current_page_item"><a href="#">Our History</a></li>
                <li><a href="#">Our Goals</a></li> -->
                </ul>
            </div>
            <?php } ?>

            <div class="generic-content">
                <?php the_content( ) ?>
            </div>
            </div>


        <?php 
    }

    get_footer();
?>