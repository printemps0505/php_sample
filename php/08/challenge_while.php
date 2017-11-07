<?php
$i = 1;
$sum = 0;
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>challenge_for</title>
</head>
<body>
    <?php
    while($i <= 100){
        if($i % 3 == 0){
        $sum += $i;
        }
        $i++;
    }
    ?>
    <p>合計：<?php print $sum;?></p>
</body>
</html>