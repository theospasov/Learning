<?php 

    // Add APIs, JS and CSS files
    function university_files() {
        wp_enqueue_script( 'homepage-carousel-js', get_theme_file_uri( '/build/index.js' ), array('jquery'), '1.0', true );
        wp_enqueue_style('google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i' ); 
        wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' ); 
        wp_enqueue_style('university_main_styles', get_theme_file_uri( '/build/style-index.css' )); 
        wp_enqueue_style('university_extra_styles', get_theme_file_uri( '/build/index.css' )); 
    }

    add_action( 'wp_enqueue_scripts', 'university_files' ); // wp_enqueue_scripts - Hey WP I want to load some CSS or JS files. To load my request, execute the function university_file

    // Creating Dynamic Menus
    function university_features() {
        register_nav_menu( 'headerMenuLocation', 'Header Menu Location' ); // arg1 - random name ; arg2 - human readable nama that will appear in Admin
        register_nav_menu( 'footerExploreMenu', 'Footer Explore Menu' ); 
        register_nav_menu( 'footerLearnMenu', 'Footer Learn Menu' ); 
        add_theme_support( 'title-tag' );
    };
   
    add_action( 'after_setup_theme', 'university_features' ); // arg1 - hook - ; arg2 random function name


    // CUSTOM QUERIES 
    // Customize behavior of Default Query - for Event Archive Page
    // This function will customize all the queries on our site. Let's say we limit the posts per page to 2, without the if() every post will be limited, Blog Posts and All Custom Post Types - EVERYWHERE - on query pages and in admin pages. This is too much and not really practical, so we need if() to limit the customization. This if checks that we're not in the WP admin, only applies to the Archive page of 'event' posts and isn't a custom query
    function university_adjust_queries($query) {
        if(!is_admin() && is_post_type_archive( 'event' ) && $query->is_main_query()) {
            $today = date('Ymd');

            $query->set('meta_key', 'event_date');
            $query->set('orderby', 'meta_value_num');
            $query->set('order', 'ASC');
            $query->set('meta_query',  array(
                array(
                  'key' => 'event_date',
                  'compare' => '>=',
                  'value' => $today,
                  'type' => 'numeric' 
                ), // we show events that are for today or in the future
            ));
        }

    }

    add_action('pre_get_posts', 'university_adjust_queries')


?>