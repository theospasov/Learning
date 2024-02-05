<h1>Test Page</h1>
<?php 
    $age = 20;
    $name = 'Peter';
    $score = 10;

    if($age < 30) {
        echo 'Correct';
    }

    if($age < 19) {
        echo 'Incorrect';
    }

    if($age == 20 && $name == 'Peter' && $score >= 9) {
        echo '&& Correct';
    }

    if($age == 10 || $name == 'Ivan' || $score == 10) {
        echo '|| Correct';
    }
?>