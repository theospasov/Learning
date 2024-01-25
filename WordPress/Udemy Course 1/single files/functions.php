<?php

// 1. Adding CSS to header.php

    function university_files() {
        wp_enqueue_style( 'university_main_styles', get_stylesheet_uri(  ) );
        
        // If we want another css file we add one more  wp_enqueue_style( 'university_main_styles', get_stylesheet_uri(  ) ); if we want to add a JS script, we use wp_enqueue_script( )
        
    };

    add_action('wp_enqueue_scripts', 'university_files' ); // (when , what function)
// 1.

?>