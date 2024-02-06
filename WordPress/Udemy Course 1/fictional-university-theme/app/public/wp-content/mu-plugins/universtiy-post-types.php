<?php 

// Creating Custom Posts Type
function university_custom_post_types() {
    
    //Event Post Type
    // We register a new Post Type with register_post_type - WP function. arg1 - name of c post type; arg2 - array that describes the c post type (https://developer.wordpress.org/reference/functions/get_post_type_labels/)
    register_post_type( 'event', array(
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


    // Program Post Type
    register_post_type( 'program', array(
        'supports' => array('title', 'editor', 'excerpt'), // add the excerpt field to the edit page of the post
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


    // Professor Post Type
    register_post_type( 'professor', array(
        'supports' => array('title', 'editor', 'excerpt', 'thumbnail'), // add the excerpt field to the edit page of the post; adds Featured Image field
        'public' => true, // visible to editors and viewers of the website
        'show_in_rest' => false, // false - New custom post types will use the old classic Editor screen
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

}; 

add_action( 'init', 'university_custom_post_types'); 
?>