<?php 
    while(have_posts()) {
        the_post(  ) ?>
            <h2><a href="<?php the_permalink( ) ?>"><?php the_title( ) ?></a></h2>
            <?php the_content() ?>
            <hr>
        <?php
    }
?>





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