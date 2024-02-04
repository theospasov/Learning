<?php 
get_header();
?>
<div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri( '/images/ocean.jpg' ) ?>)"></div>
      <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title">Past Events</h1>
        <div class="page-banner__intro">
        <p>A recap of our past events</p>
        </div>
      </div>
    </div>

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
        $eventDate = new DateTime(get_field('event_date'));
        ?>    
        <div class="event-summary">
                <a class="event-summary__date t-center" href="<?php the_permalink(); ?>#">
                <span class="event-summary__month"><?php echo $eventDate->format('M') ?></span>
                <span class="event-summary__day"><?php echo $eventDate->format('d') ?></span>
                </a>
                <div class="event-summary__content">
                <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink(); ?>"><?php the_title() ?></a></h5>
                <p><?php echo wp_trim_words( get_the_content( ), 18 ); ?><a href="<?php the_permalink(); ?>" class="nu gray">Learn more</a></p>
                </div>
            </div>
        <?php
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