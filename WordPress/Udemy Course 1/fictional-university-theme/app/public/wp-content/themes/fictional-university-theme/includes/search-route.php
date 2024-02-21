<?php 

add_action( 'rest_api_init', 'universityRegisterSearch' );

function universityRegisterSearch() {
    register_rest_route( 'uni/v1', 'search', array(
        'methods' => WP_REST_SERVER::READABLE, // For most web hosts this needs to be 'GET', but some web hosts might need a different CURD operation, so this way is the safest. This will also return 'GET' for most web hosts.
        'callback' => 'universitySearchResults', // function that will return . What it returns is what will be displayed in the JSON response.
    ) ); // |URL: site.com/wp-json/wp/v2/posts| arg1 - name space (the WP namespace is the 'wp/vx' . We MUST choose another namespace); arg2 - route (posts in the provided URL); arg3 - array that describes what should happen when someone visits this URL
}

function universitySearchResults() {
    return 'Congratiolations';
}


?>