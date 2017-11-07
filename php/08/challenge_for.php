<?php
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
    for($i = 1;$i <= 100;$i++){
        if($i % 3 == 0){
        $sum += $i;
        }
    }
    ?>
    <p>合計：<?php print $sum;?></p>
</body>
</html>