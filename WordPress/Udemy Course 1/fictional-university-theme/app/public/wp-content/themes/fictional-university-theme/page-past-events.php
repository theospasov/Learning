<?php 
get_header();
pageBanner(array(
  'title' => 'Past Events',
  'subtitle' => 'A recap of our past events'
)); 
?>

<div class="container container--narrow page-section">
  <?php 
     $today = date('Ymd'); // 20240204
     $pastEvents = new WP_Query(array(
       'paged' => get_query_var( 'paged', 1 ), // this makes pagination work
       'posts_per_page' => 10, // -1 will display all posts, a positive number will display that many of the posts
       'post_type' => 'event',
       'orderby' => 'meta_value_num', // default: post_date ; other option: title (desc alphabetically by title), rand (random), meta_value (meta data associated with the post), meta_value_num (meta data associated with the post that is numbers)
       'meta_key' => 'event_date', // we tell meta_value_num which field/data to look at
       'order' => 'ASC', //default: DESC
       'meta_query' => array(
         array(
           'key' => 'event_date',
           'compare' => '<',
           'value' => $today,
           'type' => 'numeric' 
         ), // we show events that are for today or in the future
       )
     ));
    while($pastEvents->have_posts(  )) {
        $pastEvents->the_post(); 
        get_template_part( 'template-parts/content', 'event' );
    }

    // Pagination

    
    //echo paginate_links(); // works only with default queries that are tied to the current URL
    echo paginate_links(array(
        'total' => $pastEvents->max_num_pages
    )); 
  ?>
</div>
<?php
get_footer();
?>