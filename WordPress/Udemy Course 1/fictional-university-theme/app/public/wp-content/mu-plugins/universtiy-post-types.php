<?php 

function university_custom_post_types() {
    // We register a new Post Type with register_post_type - WP function. arg1 - name of c post type; arg2 - array that describes the c post type (https://developer.wordpress.org/reference/functions/get_post_type_labels/)
    register_post_type( 'event', array(
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