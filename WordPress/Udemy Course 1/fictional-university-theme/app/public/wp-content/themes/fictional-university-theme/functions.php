<?php 
require get_theme_file_path( '/includes/search-route.php' );



    // REST API

        // Adding author name to the JSON Response
            function university_search_custom_rest() {
                register_rest_field( 'post', 'authorName', array(
                    'get_callback' => function() {return get_the_author();}
                )); // arg1 -which post type you want to change; arg2 - name of new filed; arg3 - array that describes how we want to manage this field
            }
            add_action('rest_api_init', 'university_search_custom_rest');
        //

    //


    // Add APIs, JS and CSS files
        function university_files() {
            wp_enqueue_script( 'homepage-carousel-js', get_theme_file_uri( '/build/index.js' ), array('jquery'), '1.0', true );
            wp_enqueue_style('university_extra_styles', get_theme_file_uri( '/build/index.css' ));
            wp_enqueue_style('university_main_styles', get_theme_file_uri( '/build/style-index.css' ));  
            wp_enqueue_style('google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i' ); 
            wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' ); 


            // Relative URLs for REST
            wp_localize_script( 'homepage-carousel-js', 'universityData', array(
                'root_url' => get_site_url(), // gets the site's domain
                'nonce' => wp_create_nonce('wp_rest') // Creates Nonce, used for authorizing REST API requests. It is created and deleted per user per session

            ) ); // WP function that will let us output JS data in the sourced HTML of the page. | arg1 - name of main JS file(the one we're trying to make flexible) ; arg2 - random variable name; arg3 - create an array of data, that we want to be available in JS
        }

        add_action( 'wp_enqueue_scripts', 'university_files' ); // wp_enqueue_scripts - Hey WP I want to load some CSS or JS files. To load my request, execute the function university_file
    //


    // Enable WP features
            function university_features() {
                add_theme_support( 'title-tag' ); // WP can control the <title> tag
                add_theme_support( 'post-thumbnails' ); // Enables Featured Image for Posts
                    // Crop Presets of Thumbnails - by default WP would make several copies of Featured images in different sizes. We can add extra presets that can make even more copies, but with specific dimensions.
                    // We can use the custom images with  the_post_thumbnail('professorPortrait'); arg1 is the random name we added to the preset
                    add_image_size('professorLandscape', 400, 260, true ); // Creates a image size preset / arg1 - Random name of image size; arg2 - width; arg3 - height; arg4 - crop or not, can add array with crop direction like array('left', 'top')
                    add_image_size( 'professorPortrait', 480, 650, true );
                    add_image_size('pageBanner', 1500, 350, true );


                //Dynamic Menus
                register_nav_menu( 'headerMenuLocation', 'Header Menu Location' ); // arg1 - random name ; arg2 - human readable nama that will appear in Admin
                register_nav_menu( 'footerExploreMenu', 'Footer Explore Menu' ); 
                register_nav_menu( 'footerLearnMenu', 'Footer Learn Menu' ); 

        };
    
        add_action( 'after_setup_theme', 'university_features' ); // arg1 - hook - ; arg2 random function name
    //


    // QUERY CUSTOMIZATION - Customize behavior of DEFAULT QUERIES
        function university_adjust_queries($query) { // We NEED To add if(), because otherwise this function will customize ALL queries on our site. Let's say we limit the posts per page to 2, without the if() every post will be limited, Blog Posts and All Custom Post Types - EVERYWHERE - on query pages and in admin pages. This is too much and not really practical, so we need if() to limit the customization. This if checks that we're not in the WP admin, only applies to the Archive page of 'event' posts and isn't a custom query

            // Event Archive Page
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

            // Program Archive Page
            if(!is_admin() && is_post_type_archive( 'program' ) && $query->is_main_query()) {
                $query->set('orderby', 'title');
                $query->set('order', 'ASC');
                $query->set('posts_per_page', -1); // show all Program posts

            }

        }

        add_action('pre_get_posts', 'university_adjust_queries');
    //


    // UTILITY FUNCTIONS

        function pageBanner($args = NULL) { // // Display Banner on Post Pages, based on Featured Image. If we leave it at ($args), every time someone calls the function, without argus it will cause a crash, because args is mandatory. If we make it to ($args = NULL), we are making args optional. 

            // If we haven't provided a Title, Sub or Image in the Array, when calling the function, the title should fall back to the Title, Sub, Image of the Posts in Editing
            // Why do we use isset -> Lesson 46
            if(!isset($args['title'])) { 
                $args['title'] = get_the_title();
            }

            if(!isset($args['subtitle'])) {
                $args['subtitle'] = get_field('page_banner_subtitle');
            }

            if(!isset($args['banner'])) {
                if(get_field('page_banner_image') && !is_archive() && !is_home()) { // If we have set a Banner Image in Editing. The non archive and home are explained in Lesson 47
                    $args['banner'] = get_field('page_banner_image')['sizes']['pageBanner']; // get the image and it's cropped version 
                } else { // If we don't have an image in the arguments or in Editing, use this image
                    $args['banner'] = get_theme_file_uri('images/ocean.jpg');
                }
            }

            
            ?>
            <div class="page-banner">
                <div class="page-banner__bg-image" style="background-image: url(<?php echo $args['banner']; ?>)"></div>
                    <div class="page-banner__content container container--narrow">
                        <h1 class="page-banner__title"><?php echo $args['title'] ?></h1>
                        <div class="page-banner__intro">
                        <p><?php echo $args['subtitle'] ?></p>
                    </div>
                </div>
            </div>
            <?php
        }
    //

    // USER ACTIONS
        // Redirect on login to homepage. Default is admin page
            add_action( 'admin_init', 'redirectUserToHomePage');

            function redirectUserToHomePage() {
                $currentUser = wp_get_current_user();

                if(count($currentUser->roles) == 1 && $currentUser->roles[0] == 'subscriber') {
                    wp_redirect(site_url('/') );
                    exit;
                }
            }
        //

        // Hide WP top bar
            add_action( 'wp_loaded', 'hideAdminBar');

            function hideAdminBar() {
                $currentUser = wp_get_current_user();

                if(count($currentUser->roles) == 1 && $currentUser->roles[0] == 'subscriber') {
                    show_admin_bar(false );
                }
            }
        //

        // Customize Login Screen
            // Clicking on logo takes us to Homepage, instead of WP.org
            add_filter('login_headerurl', 'customHeaderUrl' );

            function customHeaderUrl() {
                return esc_url(site_url('/'));
            }

        //

        // Load custom CSS (our excising CSS files) on Login Screen
            add_action( 'login_enqueue_scripts', 'customLoginCSS' );

            function customLoginCSS() {
                wp_enqueue_style('university_extra_styles', get_theme_file_uri( '/build/index.css' ));
                wp_enqueue_style('university_main_styles', get_theme_file_uri( '/build/style-index.css' ));  
                wp_enqueue_style('google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i' ); 
                wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' ); 
            }
        //

        add_filter('login_headertitle', 'customLoginTitle');
        function customLoginTitle() {
            return get_bloginfo('name');
        }
?>