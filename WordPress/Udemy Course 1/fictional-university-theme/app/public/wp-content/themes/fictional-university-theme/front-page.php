<?php get_header(); ?>



<div class="page-banner">
      <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri( '/images/library-hero.jpg' ) ?>)"></div>
      <div class="page-banner__content container t-center c-white">
        <h1 class="headline headline--large">Welcome!</h1>
        <h2 class="headline headline--medium">We think you&rsquo;ll like it here.</h2>
        <h3 class="headline headline--small">Why don&rsquo;t you check out the <strong>major</strong> you&rsquo;re interested in?</h3>
        <a href="<?php echo get_post_type_archive_link('program') ?>" class="btn btn--large btn--blue">Find Your Major</a>
      </div>
    </div>

<div class="full-width-split group">
      <div class="full-width-split__one">
        <div class="full-width-split__inner">
          <h2 class="headline headline--small-plus t-center">Upcoming Events</h2>
          <?php
            $today = date('Ymd'); // 20240204
            $homepageEvents = new WP_Query(array(
              'posts_per_page' => 2, // -1 will display all posts, a positive number will display that many of the posts
              'post_type' => 'event',
              'orderby' => 'meta_value_num', // default: post_date ; other option: title (desc alphabetically by title), rand (random), meta_value (meta data associated with the post), meta_value_num (meta data associated with the post that is numbers)
              'meta_key' => 'event_date', // we tell meta_value_num which field/data to look at
              'order' => 'ASC', //default: DESC
              'meta_query' => array(
                array(
                  'key' => 'event_date',
                  'compare' => '>=',
                  'value' => $today,
                  'type' => 'numeric' 
                ), // we show events that are for today or in the future
              )
            ));

            while($homepageEvents->have_posts()) {
              $homepageEvents->the_post(); ?>
                <div class="event-summary">
                  <a class="event-summary__date t-center" href="<?php the_permalink(); ?>">
                    <span class="event-summary__month"><?php 
                      $eventDate = new DateTime(get_field('event_date')); // PHP Class. It will take data from the custom field event_data. We use get_field(), because the_field() echoes the data, we just want to return it
                      echo $eventDate->format('M')
                    ?></span>
                    <span class="event-summary__day"><?php echo $eventDate->format('d') ?></span>
                  </a>
                  <div class="event-summary__content">
                    <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink(); ?>"><?php the_title() ?></a></h5>
                    <p><?php if(has_excerpt()){
                      echo get_the_excerpt();
                    } else {
                      echo wp_trim_words(get_the_content(), 18 );
                    } ?><a href="<?php the_permalink(); ?>" class="nu gray">Learn more</a></p>
                  </div>
                </div>
              <?php
            } wp_reset_postdata();
          ?>
          <p class="t-center no-margin"><a href="<?php echo get_post_type_archive_link('event') ?>" class="btn btn--blue">View All Events</a></p>
        </div>
      </div>


      <div class="full-width-split__two">
        <div class="full-width-split__inner">
          <h2 class="headline headline--small-plus t-center">From Our Blogs</h2>
          <?php
            // First we create a variable that will hold the query 
            $homepagePosts = new WP_Query(array(
              'posts_per_page' => 2, //this will limit the amount of posts per page
              'category_name' => 'Uncategorized', // only give us posts in the uncategorised category
              'post_type' => 'post' // by default it is post, if we change it to 'page', it will query pages
            )); 

            // while(have_posts()){ are tied to the default automatic query the WP does for the Home Page, which returns only 1 posts - Home itself. We want to use custom queries that belong to our new object homepagePosts. We can look inside the object and use have_posts 
            while($homepagePosts->have_posts()){
              $homepagePosts->the_post();?>
                <div class="event-summary">
                  <a class="event-summary__date event-summary__date--beige t-center" href="<?php the_permalink() ?>">
                    <span class="event-summary__month"><?php the_time('M') ?></span>
                    <span class="event-summary__day"><?php the_time('d') ?></span>
                  </a>
                  <div class="event-summary__content">
                    <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h5>
                    <p><?php if(has_excerpt()){
                      echo get_the_excerpt();
                    } else {
                      echo wp_trim_words(get_the_content(), 18 );
                    } ?><a href="<?php the_permalink() ?>" class="nu gray">Read more</a></p>
                  </div>
                </div>
              <?php
              
            } wp_reset_postdata(); // End the Custom Query Phase
          ?>

          <p class="t-center no-margin"><a href="<?php echo site_url('/blog') ?>" class="btn btn--yellow">View All Blog Posts</a></p>
        </div>
      </div>
    </div>

    <div class="hero-slider">
      <div data-glide-el="track" class="glide__track">
        <div class="glide__slides">
          <div class="hero-slider__slide" style="background-image: url(<?php echo get_theme_file_uri( '/images/bus.jpg' );?>)">
            <div class="hero-slider__interior container">
              <div class="hero-slider__overlay">
                <h2 class="headline headline--medium t-center">Free Transportation</h2>
                <p class="t-center">All students have free unlimited bus fare.</p>
                <p class="t-center no-margin"><a href="#" class="btn btn--blue">Learn more</a></p>
              </div>
            </div>
          </div>
          <div class="hero-slider__slide" style="background-image: url(<?php echo get_theme_file_uri( '/images/apples.jpg' );?>)">
            <div class="hero-slider__interior container">
              <div class="hero-slider__overlay">
                <h2 class="headline headline--medium t-center">An Apple a Day</h2>
                <p class="t-center">Our dentistry program recommends eating apples.</p>
                <p class="t-center no-margin"><a href="#" class="btn btn--blue">Learn more</a></p>
              </div>
            </div>
          </div>
          <div class="hero-slider__slide" style="background-image: url(<?php echo get_theme_file_uri( '/images/bread.jpg' );?>)">
            <div class="hero-slider__interior container">
              <div class="hero-slider__overlay">
                <h2 class="headline headline--medium t-center">Free Food</h2>
                <p class="t-center">Fictional University offers lunch plans for those in need.</p>
                <p class="t-center no-margin"><a href="#" class="btn btn--blue">Learn more</a></p>
              </div>
            </div>
          </div>
        </div>
        <div class="slider__bullets glide__bullets" data-glide-el="controls[nav]"></div>
      </div>
    </div>


   <? get_footer();
?>














<!-- <?php 
    while(have_posts()) {
        the_post(  ) ?>
            <h2><a href="<?php the_permalink( ) ?>"><?php the_title( ) ?></a></h2>
            <?php the_content() ?>
            <hr>
        <?php
    }
?> -->





<!-- <?php 

    function myFirstFunction($name) {
        echo "<p>Hello this is $name.</p>";
    }
    myFirstFunction('Mary');
    myFirstFunction('John');
?>

<h1><?php bloginfo('name'); ?></h1>
<p><?php bloginfo( 'description' ) ?></p>

<?php 
    $names= array('Brad', 'John', 'Jane', 'Ceci')
?>
<p>Hi, my name is <?php echo $names[0] ?></p>
<?php 
    $count = 0;
    while($count < count($names)) {
        echo "<li>My name is $names[$count]</li>";
        $count++;
    }
?> -->