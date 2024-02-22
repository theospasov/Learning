<?php 

add_action( 'rest_api_init', 'universityRegisterSearch' );

function universityRegisterSearch() {
    register_rest_route( 'uni/v1', 'search', array(
        'methods' => WP_REST_SERVER::READABLE, // For most web hosts this needs to be 'GET', but some web hosts might need a different CURD operation, so this way is the safest. This will also return 'GET' for most web hosts.
        'callback' => 'universitySearchResults', // function that will return . What it returns is what will be displayed in the JSON response.
    ) ); // |URL: site.com/wp-json/wp/v2/posts| arg1 - name space (the WP namespace is the 'wp/vx' . We MUST choose another namespace); arg2 - route (posts in the provided URL); arg3 - array that describes what should happen when someone visits this URL
}

function universitySearchResults($data) {
    // We create a query to tell WP which post type to search
    $mainQuery = new WP_Query(array(
        'post_type' => array('post', 'page', 'professor'),
        's' => sanitize_text_field( $data['term'] ) // will make our search term come from the Query URL ->site.com/wp-json/uni/v1/search?term=%27barksalot%27. In this case s = barksalot and WP will perform a search for a professor with that name and return their data 
    ));

    $results = array();

    // We loop through the Custom Query and we extract only the data we need and we add it to the new array
    while($mainQuery->have_posts()) {
        $mainQuery->the_post();
        array_push($results, array(
            'title' => get_the_title(),
            'permalink' => get_the_permalink(),
        ));
    }

    return $results;
}


?>