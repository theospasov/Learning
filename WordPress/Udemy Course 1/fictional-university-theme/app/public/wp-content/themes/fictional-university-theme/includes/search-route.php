<?php 

add_action( 'rest_api_init', 'universityRegisterSearch' );

function universityRegisterSearch() {
    register_rest_route( 'uni/v1', 'search', array(
        'methods' => WP_REST_SERVER::READABLE, // For most web hosts this needs to be 'GET', but some web hosts might need a different CURD operation, so this way is the safest. This will also return 'GET' for most web hosts.
        'callback' => 'universitySearchResults', // function that will return . What it returns is what will be displayed in the JSON response.
    ) ); // |URL: site.com/wp-json/wp/v2/posts| arg1 - name space (the WP namespace is the 'wp/vx' . We MUST choose another namespace); arg2 - route (posts in the provided URL); arg3 - array that describes what should happen when someone visits this URL
}

function universitySearchResults($data) {
    // We create a query to tell WP which post types to search
    $mainQuery = new WP_Query(array(
        'post_type' => array('post', 'page', 'professor', 'program', 'campus', 'event'),
        's' => sanitize_text_field( $data['term'] ) // will make our search term come from the Query URL ->site.com/wp-json/uni/v1/search?term=%27barksalot%27. In this case s = barksalot and WP will perform a search for a professor with that name and return their data 
    ));

    $results = array(
        'generalInfo' => array(),
        'professors' => array(),
        'programs' => array(),
        'events' => array(),
        'campuses' => array(),
    );

    // We loop through the Custom Query and we extract only the data we need and we add it to the appropriate empty array 
    while($mainQuery->have_posts()) {
        $mainQuery->the_post();

        if(get_post_type() == 'post' || get_post_type() == 'page') {
            array_push($results['generalInfo'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
                'postType' => get_post_type(),
                'authorName' => get_the_author(),
            ));
        }

        if(get_post_type() == 'professor' ) {
            array_push($results['professors'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
                'image' => get_the_post_thumbnail_url( 0, 'professorLandscape' ) // arg1 - which image, 0 means from the current post; arg2 - size
            ));
        }

        if(get_post_type() == 'program' ) {
            $relatedCampuses = get_field('related_campuses');

            if($relatedCampuses) {
                foreach($relatedCampuses as $campus) {
                    array_push($results['campuses'], array(
                        'title' => get_the_title($campus),
                        'permalink' => get_the_permalink($campus),
                    ));
                }
            }

            array_push($results['programs'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
                'id' => get_the_ID(),
            ));
        }

        if(get_post_type() == 'campus' ) {
            array_push($results['campuses'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
            ));
        }

        if(get_post_type() == 'event' ) {
            $eventDate = new DateTime(get_field('event_date')); // PHP Class. It will take data from the custom field 
            $description = null;

            if(has_excerpt()){
                $description = get_the_excerpt();
            } else {
                $description = wp_trim_words(get_the_content(), 18 );
            } 

            array_push($results['events'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
                'month' => $eventDate->format('M'),
                'day' => $eventDate->format('d'),
                'description' => $description
            ));
        }

    }

    // Query the looks for relationships. In the case we look for a name of a program, it will find all the professors in relationship with the searched program. 
    if($results['programs']) {
        
        $programsMetaQuery = array('relation' => 'OR');

        foreach ($results['programs'] as $item ) {
            array_push($programsMetaQuery, array(
                'key' => 'related_programs',
                'compare' => 'LIKE',
                'value' => '"' . $item['id'] . '"',
            )); 
        }

        
        $programRelationship = new WP_Query(array(
            'post_type' => array('professor', 'event'),
            'meta_query' => $programsMetaQuery
        ));

        while($programRelationship->have_posts()) {
            $programRelationship->the_post();

            if(get_post_type() == 'professor' ) {
                array_push($results['professors'], array(
                    'title' => get_the_title(),
                    'permalink' => get_the_permalink(),
                    'image' => get_the_post_thumbnail_url( 0, 'professorLandscape' ) // arg1 - which image, 0 means from the current post; arg2 - size
                ));
            }

            if(get_post_type() == 'event' ) {
                $eventDate = new DateTime(get_field('event_date')); // PHP Class. It will take data from the custom field 
                $description = null;

                if(has_excerpt()){
                    $description = get_the_excerpt();
                } else {
                    $description = wp_trim_words(get_the_content(), 18 );
                } 

                array_push($results['events'], array(
                    'title' => get_the_title(),
                    'permalink' => get_the_permalink(),
                    'month' => $eventDate->format('M'),
                    'day' => $eventDate->format('d'),
                    'description' => $description
                ));
            }
        }

        $results['professors'] = array_values(array_unique($results['professors'], SORT_REGULAR)); //will remove duplicates array elements. arg1 - array to work with. arg2 - please look inside each sub-item of an array to determine if they are duplicate or not
        $results['events'] = array_values(array_unique($results['events'], SORT_REGULAR)); 

    }


    return $results;
}


?>