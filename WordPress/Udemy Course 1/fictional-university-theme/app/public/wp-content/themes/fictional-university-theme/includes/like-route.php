<?php 

add_action( 'rest_api_init', 'universityLikeRoutes' );

function universityLikeRoutes() {
    register_rest_route( 'uni/v1', 'manageLike', array(
        'methods' => 'POST',
        'callback' => 'createLike',
    ) );
    
    register_rest_route( 'uni/v1', 'manageLike', array(
        'methods' => 'DELETE',
        'callback' => 'deleteLike',
    ) );

}

function createLike() {
    return 'you tried to create a like';
}

function deleteLike() {
    return 'you tried to delete a like';
}

?>