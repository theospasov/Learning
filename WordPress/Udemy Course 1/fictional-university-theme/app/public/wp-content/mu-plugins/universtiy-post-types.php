<?php 

// Creating Custom Posts Type
function university_custom_post_types() {
    
    //Event Post Type
        // We register a new Post Type with register_post_type - WP function. arg1 - name of c post type; arg2 - array that describes the c post type (https://developer.wordpress.org/reference/functions/get_post_type_labels/)
        register_post_type( 'event', array(
            'capability_type' => 'event', // detaches Event Posts Types from all Posts when it comes to Capability of User Roles. default == 'post'
            'map_meta_cap' => 'true', // gives us the ability to inforce new capabilities for User Roles
            'supports' => array('title', 'editor', 'excerpt'), // add the excerpt field to the edit page of the post
            'has_archive' => true, // Important - if we want site.com/event to open All Event Posts
            'rewrite' => array('slug' => 'events'), // changes the slug to plural, so we can access all Events at site.com/events not site.com/event. The event slug comes form arg1 of register_post_type()
            'public' => true, // visible to editors and viewers of the website
            'show_in_rest' => false, // false - New custom post types will use the old classic Editor screen
            'labels' => array(
                'name' => 'Events',
                'add_new' => 'Add New Event',
                'add_new_item' => 'Add New Event',
                'edit_item' => 'Edit Event',
                'all_items' => 'All Events',
                'singular_name' => 'Event'
            ),
            'menu_icon' => 'dashicons-calendar'
        )); 
    //

    // Program Post Type
        register_post_type( 'program', array(
            'supports' => array('title'), // add the excerpt field to the edit page of the post
            'has_archive' => true, // Important - if we want site.com/event to open All Event Posts
            'rewrite' => array('slug' => 'programs'), // changes the slug to plural, so we can access all Events at site.com/events not site.com/event. The event slug comes form arg1 of register_post_type()
            'public' => true, // visible to editors and viewers of the website
            'show_in_rest' => false, // false - New custom post types will use the old classic Editor screen
            'labels' => array(
                'name' => 'Programs',
                'add_new' => 'Add New Program',
                'add_new_item' => 'Add New Program',
                'edit_item' => 'Edit Program',
                'all_items' => 'All Programs',
                'singular_name' => 'Program'
            ),
            'menu_icon' => 'dashicons-awards'
        ));
    // 


    // Professor Post Type
        register_post_type( 'professor', array(
            'supports' => array('title', 'editor', 'excerpt', 'thumbnail'), // add the excerpt field to the edit page of the post; adds Featured Image field
            'public' => true, // visible to editors and viewers of the website
            'show_in_rest' => true, // | REST URL: http://fictional-university-theme.local/wp-json/wp/v2/professor|  false - New custom post types will use the old classic Editor screen and the URL won't work. true - New post Editor and data will show at REST URL
            'labels' => array(
                'name' => 'Professors',
                'add_new' => 'Add New Professor',
                'add_new_item' => 'Add New Professor',
                'edit_item' => 'Edit Professor',
                'all_items' => 'All Professors',
                'singular_name' => 'Professor'
            ),
            'menu_icon' => 'dashicons-welcome-learn-more'
        )); 
    //


    // Campus Post Type
        register_post_type( 'campus', array(
                'supports' => array('title', 'editor', 'excerpt'), // add the excerpt field to the edit page of the post
                'has_archive' => true, // Important - if we want site.com/event to open All Event Posts
                'rewrite' => array('slug' => 'campuses'), // changes the slug to plural, so we can access all Events at site.com/events not site.com/event. The event slug comes form arg1 of register_post_type()
                'public' => true, // visible to editors and viewers of the website
                'show_in_rest' => false, // false - New custom post types will use the old classic Editor screen
                'labels' => array(
                    'name' => 'Campuses',
                    'add_new' => 'Add New Campus',
                    'add_new_item' => 'Add New Campus',
                    'edit_item' => 'Edit Campus',
                    'all_items' => 'All Campuses',
                    'singular_name' => 'Campus'
                ),
                'menu_icon' => 'dashicons-location-alt'
        )); 

    //

    // Note Post Type
        register_post_type( 'note', array(
            'show_in_rest' => true, // will work with the REST API
            'supports' => array('title', 'editor'),
            'public' => false, // notes have to private and specific to each user, but also will hide it from the admin dashboard
            'show_ui' => true, // will show in the admin dashboard
            'labels' => array(
                'name' => 'Notes',
                'add_new' => 'Add New Note',
                'add_new_item' => 'Add New Note',
                'edit_item' => 'Edit Note',
                'all_items' => 'All Notes',
                'singular_name' => 'Note'
            ),
            'menu_icon' => 'dashicons-welcome-write-blog'
        )); 
    //


}; 

add_action( 'init', 'university_custom_post_types'); 
?>