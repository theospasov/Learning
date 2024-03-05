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

function createLike($data) {
    if(is_user_logged_in()) {
        $professorID = sanitize_text_field( $data['professorId'] );

        $existQuery = new WP_Query(array(
            'author' => get_current_user_id(),
            'post_type' => 'like',
            'meta_query' => array(
                array(
                    'key' => 'liked_professor_id',
                    'compare' => '=',
                    'value' => $professorID,
                )
            )
        ));

        if($existQuery->found_posts == 0 && get_post_type($professorID) == 'professor') {
            return wp_insert_post(array(
                'post_type' => 'like',
                'post_status' => 'publish', // def - draft
                'post_title' => 'Second PHP Test',
                'meta_input' => array(
                    'liked_professor_id' => $professorID // the prof custom field from ACF
                )
            )); // programmatically create a new post, right from PHP
        } else {
            die('Invalid professor id');
        }


    } else {
        die("Only logged in users can create a like");
    }

}

function deleteLike() {
    return 'you tried to delete a like';
}

?>