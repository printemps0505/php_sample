<?php
$i = 1;
?>
<!DOCTYPE html>
<html lang="ja>
<head>
    <meta charset="utf-8>
    <title></title>
</head>
<body>
    <?php
    while($i <= 100){
        if($i % 3 == 0 && $i % 5 == 0){
    ?>
            <p>FizzBuzz</p>
    <?php
        }else if($i % 3 == 0){
    ?>
            <p>Fizz</p>
    <?php
        }else if($i % 5 == 0){
    ?>
            <p>Buzz</p>
    <?php
        }else{
    ?>
            <p><?php print $i;?></p>
    <?php
        }
    $i++;
    }
    ?>
</body>
</html>