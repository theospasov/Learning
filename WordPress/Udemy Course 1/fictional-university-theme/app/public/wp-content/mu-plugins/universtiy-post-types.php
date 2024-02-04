<?php 

function university_custom_post_types() {
    // We register a new Post Type with register_post_type - WP function. arg1 - name of c post type; arg2 - array that describes the c post type (https://developer.wordpress.org/reference/functions/get_post_type_labels/)
    register_post_type( 'event', array(
        'show_in_rest' => false, // if true will have new Editor
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
}; 

add_action( 'init', 'university_custom_post_types'); 
?>