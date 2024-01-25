<?php 
    $names = array("Barry", 'Chad', 'Emily');
    $count = 0;

    while($count < count($names)) {
        echo "<li>Hi my name is $names[$count]</li>";
        $count++;
    }

?>

<p>Hi my name is <?php echo $names[0] ?></p>


<li></li>


<!-- $count = 1;
    while($count < 10) {
        echo "<li>$count</li>";
        $count++;
    }; -->